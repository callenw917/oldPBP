<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}

$timezone = date_default_timezone_set("America/Chicago");

// Local Testing
//$connection = mysqli_connect("localhost","root","","pbp");

// Heroku ClearDB Connection
 $url=parse_url(getenv("CLEARDB_DATABASE_URL"));

  $server   = $url["host"];
  $username = $url["user"];
  $password = $url["pass"];
  $db       = substr($url["path"],1);
  $host     = "mysql:host=$server;dbname=$db";
  $connection = mysqli_connect($server , $username, $password, $db);


if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}

?>