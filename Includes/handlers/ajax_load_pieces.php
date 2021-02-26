<?php
include($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/User.php');

$projectID = $_POST['projectID'];
$chapterID = $_POST['chapterID'];
$username = $_POST['username'];
$project = $_POST['project'];



$writer_query = mysqli_query($connection,"SELECT * FROM project_user WHERE project='$projectID' AND username='$username'");
$row = mysqli_fetch_array($writer_query);
$lastLoad = $row['lastLoad'];
$project_userID = $row['id'];
$lastLoadTime = new DateTime($lastLoad);

$pieces = mysqli_query($connection, "SELECT * FROM entries WHERE chapter='$chapterID' AND deleted='0' ORDER BY id ASC");
$str = "";
while($row = mysqli_fetch_array($pieces)) {
    $time = $row['time'];
    $post_date = new DateTime($time);
    if ($post_date > $lastLoadTime) {
        $id = $row['id'];
        $content = $row['content'];
        $writer = $row['user'];
        $color = $row['color'];
        

        $time_now = date("Y-m-d H:i:s");
        $time_now = new DateTime($time_now);
        $time_pass = $post_date->diff($time_now);

        if ($time_pass->y >= 1) {
            if ($time_pass->y == 1)
                $time_message = "1 year ago";
            else    
                $time_message = $time_pass->y . " years ago";
        } else if ($time_pass->m >= 1) {
            if ($time_pass->m == 1)
                $time_message = "1 month ago";
            else    
                $time_message = $time_pass->m . " months ago";
        } else if ($time_pass->d >= 1) {
            if ($time_pass->d == 1)
                $time_message = "1 day ago";
            else    
                $time_message = $time_pass->d . " days ago";
        } else if ($time_pass->h >=1) {
            if ($time_pass->h == 1)
                $time_message = "1 hour ago";
            else    
                $time_message = $time_pass->h . " hours ago";
        } else if ($time_pass->i >=1) {
            if ($time_pass->i == 1)
                $time_message = "1 minute ago";
            else    
                $time_message = $time_pass->i . " minutes ago";
        } else if ($time_pass->s >=1) {
            if ($time_pass->s == 1)
                $time_message = "1 second ago";
            else    
                $time_message = $time_pass->s . " seconds ago";
        }
        $_SESSION['latest_entry'] = $id;
        $str .= "<div class='piece_div'><p id='" . $id . "' style='border-left: .2vw outset " . $color . ";'>" . $content . "</p><form action='" . $project . "' method='POST'><button name='delete' id='delete' ><i class='fas fa-times'></i></button></form></div>";
    }
}
       
echo $str;

$date_loaded = date("Y-m-d H:i:s");
$update_loaded = mysqli_query($connection, "UPDATE project_user SET lastLoad='$date_loaded' WHERE id='$project_userID'");

?>