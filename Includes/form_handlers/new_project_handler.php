<?php
//Declaring Variables
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/Project.php');
$name = "";
$url_name ="";
$userLoggedIn = $_SESSION['username'];
$users;
$date = date("Y-m-d");

$error_array = array();


if(isset($_POST['submit_button'])) {
    $name = strip_tags($_POST['project_name']);
    $url_name = strip_tags($_POST['project_url_name']);
    $url_name = str_replace(' ','',$url_name);

    //CHECK URL
    if(strlen($url_name) > 100 || strlen($url_name) < 3) {
        array_push($error_array, "Your username must be between 3 and 100 characters<br>"); 
    }
    $url_check = mysqli_query($connection,"SELECT url_name FROM projects WHERE url_name='$url_name'");
    $num_rows = mysqli_num_rows($url_check);
    if($num_rows > 0) {
        array_push($error_array, "URL already in use<br>");
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(empty($error_array)) {
        $insert_query = mysqli_query($connection,"INSERT INTO projects VALUES ('','$name','$url_name','1','1','$userLoggedIn','1','$date')");
        $project_query = mysqli_query($connection,"SELECT * FROM projects WHERE url_name='$url_name'");
        $row = mysqli_fetch_array($project_query);
        $id = $row['id'];
        //$insert_query = mysqli_query($connection,"INSERT INTO project_user VALUES ('','$id','$userLoggedIn','#000000','1')");
        $project = new Project($connection,$url_name,$userLoggedIn);
        $project->addUser($userLoggedIn);
        $insert_query = mysqli_query($connection,"INSERT INTO chapters VALUES ('','Chapter 1','$id','','','$date',1)");
    }



}

?>