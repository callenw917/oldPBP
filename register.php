<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
    require $_SERVER['DOCUMENT_ROOT'].'/Includes/form_handlers/register_handler.php';
    require $_SERVER['DOCUMENT_ROOT'].'/Includes/form_handlers/login_handler.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pieceward</title>
        <link rel="stylesheet" type="text/css" href='assets/css/register_style.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='assets/js/register.js'></script>
        <script src='assets/js/background_pieces.js'></script>
    </head>




    <body>
    <?php
    if(isset($_POST['register_button'])) {
        echo '
        <script>
            $(document).ready(function() {
                $("#first").hide();
                $("#second").show();
            });
        </script>
        ';
    }
    ?>



    <div id="background"></div>


    <div id="left-wrapper">
        <div id="header">
            
            <h1 id="title">PIECEWARD</h1>
            <h1>Welcome Back!</h1>
            <h3>Let's get to writing.</h3>
        </div>

        <div class="login-page">
        <div class="form">
            <div id="first">
                <form class="login-form" action="register.php" method="POST">
                    <input type="text" name="log_email_username" placeholder="Email or Username" value="<?php 
                    if(isset($_SESSION['log_email_username'])) {
                        echo $_SESSION['log_email_username'];
                    }?>" required/>
                    <input type="password" name="log_pass" placeholder="Password" required/>
                    <button name = "login_button">login</button>
                    <p class="login_fail_message"><?php if(in_array("Email or password was incorrect<br>", $error_array)) echo "Email or password was incorrect<br>";?></p>
                    <p class="message">Not registered? <a href="#" id="register">Create an account</a></p>
                </form>
            </div>

            <div id="second">
                <form class="register-form" action="register.php" method="POST">
                    <!-- //NAME -->
                    <div class="field">
                        <input class="name" id="fName" type="text" name="reg_name_first" placeholder="First Name" value="<?php 
                        if(isset($_SESSION['reg_name_first'])) {
                            echo $_SESSION['reg_name_first'];
                        }?>" required/>
                            
                        <input class="name" id="lName" type="text" name="reg_name_last" placeholder="Last Name" value="<?php 
                        if(isset($_SESSION['reg_name_last'])) {
                            echo $_SESSION['reg_name_last'];
                        }?>" required/>
                        <?php if(in_array("Your first name must be between 2 and 50 characters<br>",$error_array)) echo "<p id='error_name' class='error'>Both names must be between 4 and 50 characters<br></p>"; else if(in_array("Your last name must be between 2 and 50 characters<br>",$error_array)) echo "<p id='error_name' class='error'>Both names must be between 4 and 50 characters<br></p>"; ?>
                    </div>
                    <!-- //EMAIL -->
                    <div class="field">
                        <input type="email" name="reg_email" placeholder="Email Address" value="<?php 
                        if(isset($_SESSION['reg_email'])) {
                            echo $_SESSION['reg_email'];
                        }?>" required/>
                        <?php if(in_array("Email already in use<br>",$error_array)) echo "<p id='error_email' class='error'>Email already in use<br></p>";
                        else if(in_array("Invalid format<br>",$error_array)) echo "<p id='error_email_2' class='error'>Invalid format<br></p>"; ?>
                    </div>
                    <!-- //USERNAME -->
                    <div class="field">
                        <input type="text" name="reg_username" placeholder="Username" value="<?php 
                        if(isset($_SESSION['reg_username'])) {
                            echo $_SESSION['reg_username'];
                        }?>" required/>
                        <?php if(in_array("Your username must be between 6 and 50 characters<br>",$error_array)) echo "<p id='error_username' class='error'>Your username must be between 6 and 50 characters<br></p>"; 
                        else if(in_array("Username already in use<br>",$error_array)) echo "<p id='error_username' class='error'>Username already in use<br></p>"; ?>
                    </div>
                    <!-- //PASSWORD -->
                    <div class="field">
                        <input type="password" name="reg_pass" placeholder="Password" required/>
                        <?php if(in_array("Your password can only contain letters or numbers<br>",$error_array)) echo "<p id='error_pass' class='error'>Your password can only contain letters or numbers<br></p>"; 
                        else if(in_array("Your password must be between 6 and 30 characters<br>",$error_array)) echo "<p id='error_pass' class='error'>Your password must be between 6 and 30 characters<br></p>"; ?>
                    </div>
                    <!-- //CONFIRM PASSWORD -->
                    <div class="field">
                        <input type="password" name="reg_passconf" placeholder="Confirm Password" required/>
                        <?php if(in_array("Your passwords do not match<br>",$error_array)) echo "<p id='error_pass_conf' class='error'>Your passwords do not match<br></p>"; ?>
                    </div>
                    <button name="register_button" >Register</button>

                    <p class="message">Already registered? <a href="#" id="login">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>
    <div id="right-wrapper">
        <img id="story-image" src="/assets/images/story_capture.png" alt="">
        <h3>Write <span>together</span> one piece at a time</h3>
        
    </div>



    </body>
    
</html>