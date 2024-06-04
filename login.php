<?php
$alert_message = '';
session_start(); // Start the session

// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION['email'])) {
  header("Location: dashboard.php");
  exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include ("src/connect.php");
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare the SQL statement with parameterized query
  $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE email = ?");
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // Get the result set

    // Check if there is a user with that email and password
    if (mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_object($result);

      // Compare hashed password
      if (password_verify($password, $user->password)) {
        include ('src/gmail.php');
        $alert_message = create_success_alert('Login Successful.');
        $_SESSION['email'] = $user->email;
        $_SESSION['firstname'] = $user->first_name;
        $_SESSION['middlename'] = $user->middle_name;
        $_SESSION['surname'] = $user->surname;
        $to = $user->email;
        $subject = 'You logged in.';
        $body = 'Hi, dear <b>' . $user->first_name . ' ' . $user->surname . '</b> You just logged in.';
        $altBody = 'This is to inform you that you logged in to our site.';

        $result = sendEmail($to, $subject, $body, $altBody);
        if ($result === true) {
          echo 'Message has been sent';
        } else {
          echo $result;
        }
        header("Location: dashboard.php");
        exit();
      } else {
        $alert_message = create_error_alert('Login Failed.');
      }
    } else {
      $alert_message = '<div id="alert-container" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
              <strong class="font-bold">Error</strong>
              <span class="block sm:inline">Invalid email or password</span>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg id="alert-btn" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
              </span>
              <script>
              const alertBtn = document.getElementById("alert-btn");
              const alertContainer = document.getElementById("alert-container");
            
              if(alertBtn){
                alertBtn.addEventListener("click", () => alertContainer.outerHTML = "");
              }
              </script>
            </div>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
  } else {
    echo "Error preparing statement: " . mysqli_error($con);
  }

  // Close the connection
  mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'src/header.php';
  ?>
  <script src="public/js/form.js"></script>
  <title>Login</title>
</head>

<body>
  <?php
  include 'src/nav.php';
  ?>

  <div class="w-full max-w-xs sm:max-w-[800px] mx-auto my-8">
    <form action="login.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <?php
      if (strlen($alert_message) > 0)
        echo $alert_message;
      ?>
      <h1 class="text-center m-2 font-extrabold">Login</h1>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
          Email
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-2 focus:outline-primary-color"
          id="email" name="email" type="text" placeholder="Email">
      </div>
      <div class="relative mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input
          class="shadow appearance-none border border-danger-color rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-2 focus:outline-primary-color"
          id="password" name="password" type="password" placeholder="******************" />
        <span id="show-pass" class="absolute cursor-pointer top-0 right-1 inline-block"></span>
        <p class="text-danger-color text-xs italic">Please put your password.</p>
      </div>
      <div class="flex items-center justify-between flex-col xxs:flex-row">
        <button
          class="bg-primary-color hover:bg-secondary-color text-white font-bold py-2 px-4 rounded focus:outline-2 focus:outline-primary-color"
          type="submit">
          Login
        </button>
        <a class="inline-block align-baseline font-bold text-sm text-primary-color hover:text-secondary-color" href="#">
          Forgot Password?
        </a>
      </div>
    </form>
    <?php include "src/footer.php" ?>
  </div>
</body>

</html>