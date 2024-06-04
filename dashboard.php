<?php
session_start();
if(!isset($_SESSION["email"])){
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include 'src/header.php';
    ?>
    <title>Dashboard</title>
</head>

<body>
    <?php
    include 'src/nav.php';
    ?>
    <div class="p-2">
        <div class="max-w-[800px] mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-2xl font-semibold text-primary-color">Dashboard</h2>
                <p>Welcome back, <?php echo $_SESSION["firstname"] ?></p>
                <div class="mt-4">
                    <!-- Your dashboard content goes here -->
                    <p>This is a simple PHP dashboard using Tailwind CSS.</p>
                    <!-- Add more content as needed -->
                    <?php
                        if(isset($_SESSION['alert_message'])){
                            echo '<div class="close-alert cursor-pointer">'.$_SESSION['alert_message'].'</div>';
                        }
                    ?>
                    <div class="grid grid-cols-2 items-center justify-center">
                        <?php
                        $data = [];
                        for ($i = 0; $i < 8; $i++) {
                            $data[] = ' ';
                        }

                        $html = "";
                        foreach ($data as $item) {
                            $html .= '<div class="flex-1 bg-gray-400 h-12 w-12 m-2">'.$item.'</div>';
                        }
                        echo $html;
                        ?>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="logout.php" class="text-sm text-primary-color hover:text-secondary-color">Logout</a>
                </div>
                <!-- <div class="mt-6">
                    <a href="clamp.php" class="text-sm text-primary-color hover:text-secondary-color">Clamp.js</a>
                </div> -->
            </div>
        </div>
    </div>
    <?php include "src/footer.php" ?>
</body>

</html>