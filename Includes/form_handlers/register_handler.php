<?php
//Declaring variables
$fname = "";
$lname = "";
$email = "";
$username = "";
$pass = "";
$passconf = "";
$date = "";
$error_array = array(); //Holds any error form

if(isset($_POST['register_button'])) {
    //Register values from form
    $fname = strip_tags($_POST['reg_name_first']);
    $lname = strip_tags($_POST['reg_name_last']);
    $_SESSION['reg_name_first'] = $fname; //Stores name in session var
    $_SESSION['reg_name_last']  = $lname;

    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(' ','',$email);
    $_SESSION['reg_email'] = $email; //Stores email in session var

    $username = strip_tags($_POST['reg_username']);
    $_SESSION['reg_username'] = $username; //Stores name in session var

    $pass = strip_tags($_POST['reg_pass']);

    $passconf = strip_tags($_POST['reg_passconf']);

    $date = date("Y-m-d");

    //CHECK EMAIL
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $email_check = mysqli_query($connection,"SELECT email FROM users WHERE email='$email'");

        $num_rows = mysqli_num_rows($email_check);
        if($num_rows > 0) {
            array_push($error_array, "Email already in use<br>");
        }
    } else {
        array_push($error_array, "Invalid format<br>");
    }

    //CHECK PASSWORD
    if($pass == $passconf) {
        //check if passwords are valid
        if(preg_match('/[^A-Za-z0-9]/', $pass)) {
            array_push($error_array, "Your password can only contain letters or numbers<br>"); 
        }
    } else {
        array_push($error_array, "Your passwords do not match<br>");
    }
    if(strlen($pass) > 30 || strlen($pass) < 6) {
        array_push($error_array, "Your password must be between 6 and 30 characters<br>"); 
    }

    //CHECK NAME
    if(strlen($fname) > 50 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 50 characters<br>"); 
    }
    if(strlen($lname) > 50 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 50 characters<br>"); 
    }

    //CHECK USERNAME
    if(strlen($username) > 50 || strlen($username) < 6) {
        array_push($error_array, "Your username must be between 6 and 50 characters<br>"); 
    }
    $username_check = mysqli_query($connection,"SELECT username FROM users WHERE username='$username'");
    $num_rows = mysqli_num_rows($username_check);
    if($num_rows > 0) {
        array_push($error_array, "Username already in use<br>");
    }


    //BEGIN DATA ENTRY
    if(empty($error_array)) {
        $pass = md5($pass); //Encrypt password
        $random = rand(1,5); //Creates a random number between 1 and five
        switch ($random) {
            case 1:
                $profile_pic = $_SERVER['DOCUMENT_ROOT']."/assets/images/default_prof_pics/default_1.svg";
                break;
            case 2:
                $profile_pic = $_SERVER['DOCUMENT_ROOT']."/assets/images/default_prof_pics/default_2.svg";
                break;
            case 3:
                $profile_pic = $_SERVER['DOCUMENT_ROOT']."/assets/images/default_prof_pics/default_3.svg";
                break;
            case 4:
                $profile_pic = $_SERVER['DOCUMENT_ROOT']."/assets/images/default_prof_pics/default_4.svg";
                break;
            case 5:
                $profile_pic = $_SERVER['DOCUMENT_ROOT']."/assets/images/default_prof_pics/default_5.svg";
                break;
        }

        $insert_query = mysqli_query($connection,"INSERT INTO users VALUES ('','$fname','$lname','$username','$email','$pass','$date','$profile_pic','#737373','0','no')");

        //Clear session variables
        $_SESSION['reg_name_first'] = "";
        $_SESSION['reg_name_last'] = "";
        $_SESSION['reg_username'] = "";
        $_SESSION['reg_email'] = "";

        //Automatically Log the user in!!
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();

    } else {
        
    }

}
?>