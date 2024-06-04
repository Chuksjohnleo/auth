<?php
include('main.php');
function create_error_alert($alert_info)
{
  return '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error</strong>
                <span class="block sm:inline">' . $alert_info . '</span>
              </div>';
}

function create_success_alert($alert_info)
{
  return '<div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
  <p class="font-bold">Success</p>
  <p class="text-sm">' . $alert_info . '</p>
</div>';
}

$HOSTNAME = $_ENV['DB_HOSTNAME'];
$USERNAME = $_ENV['DB_USERNAME'];
$PASSWORD = $_ENV['DB_PASSWORD'];
$DATABASE = $_ENV['DB_NAME'];

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$con) {
    die(mysqli_error($con));
}