<?php
$alert_message = '';
session_start(); // Start the session

// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION['email'])) {
  header("Location: dashboard.php");
  exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Database connection
  include "src/connect.php"; // Ensure this file exists and contains correct database connection code
  // Validate form fields
  $required_fields = ['surname', 'firstname', 'middlename', 'email', 'password'];
  $is_form_ok = true;
  foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
      $alert_message = create_error_alert(ucfirst($field) . ' field is empty.');
      $is_form_ok = false;
      break;
    }
  }

  if ($is_form_ok) {
    // Sanitize and hash password
    $surname = $_POST['surname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_user_stmt = mysqli_prepare($con, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check_user_stmt, "s", $email);
    mysqli_stmt_execute($check_user_stmt);
    mysqli_stmt_store_result($check_user_stmt);
    if (mysqli_stmt_num_rows($check_user_stmt) > 0) {
      $alert_message = create_error_alert('Email Already Exist');
    } else {
      // Insert user data
      $stmt = mysqli_prepare($con, "INSERT INTO users(surname, first_name, middle_name, email, password) VALUES(?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "sssss", $surname, $firstname, $middlename, $email, $password);
      if (mysqli_stmt_execute($stmt)) {
        $alert_message = '<div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <p class="font-bold">Success</p>
                    <p class="text-sm">Record inserted successfully.</p>
                </div>';
        $_SESSION['email'] = $email;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['middlename'] = $middlename;
        $_SESSION['surname'] = $surname;
        $_SESSION['alert_message'] = create_success_alert('Registration Successful');

        include ('src/gmail.php');
        $to = $email;
        $subject = 'Welcome to Auth';
        $body = 'Welcome to Auth dear <b>' . $firstname . ' ' . $surname . '</b>. Thank you for checking us out.';
        $altBody = 'Welcome to auth <b>' . $firstname . '</b>';

        $result = sendEmail($to, $subject, $body, $altBody);
        if ($result === true) {
          echo 'Message has been sent';
        } else {
          echo $result;
        }
        header("Location: dashboard.php");
        exit();
      } else {
        $alert_message = create_error_alert('Error inserting record: ' . mysqli_error($con));
      }
      mysqli_stmt_close($stmt);
    }

    mysqli_close($con); // Close the database connection
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'src/header.php';
  ?>
  <script src="public/js/form.js"></script>
  <title>Register</title>
</head>

<body>
  <?php
  include 'src/nav.php';
  ?>

  <div class="w-full max-w-xs sm:max-w-[800px] mx-auto my-8">
    <form action="register.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <?php
      if (strlen($alert_message) > 0)
        echo $alert_message;
      ?>
      <h1 class="text-center m-2 font-extrabold">Register</h1>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">
          Surname
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-2 focus:outline-primary-color"
          id="surname" name="surname" type="text" placeholder="Surname">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">
          First Name
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-2 focus:outline-primary-color"
          id="firstname" name="firstname" type="text" placeholder="First Name">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="middlename">
          Middle Name
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-2 focus:outline-primary-color"
          id="middlename" name="middlename" type="text" placeholder="Middle Name">
      </div>
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
          class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-2 focus:outline-primary-color"
          id="password" name="password" type="password" placeholder="******************">
        <span id="show-pass" class="absolute cursor-pointer top-0 right-1 inline-block"></span>
        <p class="text-danger-color text-xs italic">Please choose a password.</p>
      </div>
      <div class="flex items-center justify-between">
        <button
          class="bg-primary-color hover:bg-secondary-color text-white font-bold py-2 px-4 rounded focus:outline-2 focus:outline-primary-color"
          type="submit">
          Register
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