<?php
if(isset($_POST['login_button'])) {

    $email_username = filter_var($_POST['log_email_username'], FILTER_SANITIZE_EMAIL); //sanatize email
    $_SESSION['log_email_username'] = $email_username;
    
    $password = md5($_POST['log_pass']);

    $check_database_query = mysqli_query($connection,"SELECT * FROM users WHERE email='$email_username' AND password='$password'");
    $check_login_query = mysqli_num_rows($check_database_query);
    if ($check_login_query == 0) {
        $check_database_query = mysqli_query($connection,"SELECT * FROM users WHERE username='$email_username' AND password='$password'");
        $check_login_query = mysqli_num_rows($check_database_query);
    }

    if ($check_login_query == 1) {
        $row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];

        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        array_push($error_array, "Email or password was incorrect<br>");
        $_SESSION['log_email_username'] = $email_username;
    }
}
?>