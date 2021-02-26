<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
require $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/Includes/form_handlers/new_project_handler.php';
include($_SERVER['DOCUMENT_ROOT'].'/Includes/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/User.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/Piece.php');

$user_obj = new User($connection, $userLoggedIn);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pieceward</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href='assets/css/style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='assets/js/home.js'></script>
    <script src='assets/js/background_pieces.js'></script>
</head>
<body>
    <div id="background">
        <object id="piece-upright" class="bg-piece-upright" type="image/svg+xml" data="assets/images/puzzle_piece_bg.svg"></object>
        <object id="piece-sideways" class="bg-piece-sideways" type="image/svg+xml" data="assets/images/puzzle_piece_bg_rotated.svg"></object>
    </div>
    <div id="color-bar"></div>
    <div id="header">
        <div id="dropDown">
            <button id="menuButton" class="dropbtn"><i class="dropbtnicon fas fa-bars"></i></button>
            <div id="menu">
                <a class="menuItem" href="index.php">Home</a>
                <a class="menuItem" href="#">Settings</a>
                <a class="menuItem" href="release_notes.php">Release Notes</a>
                <a id="logoutButton" class="menuItem" href="Includes/handlers/logout.php">Log Out</a>
            </div>
        </div>
    </div>

    
    <div id="panels">
        <div id="news" class="panel">
            <div id="news-holder" class="panel-holder">
            <div class="panel-label"><h5 >News</h5></div>
                <div id="main-news-holder" class="main-panel-holder">
                    <div id="news-title"><h6>First News!</h6><span>05/28/2019</span></div>
                    <p>Get your weekly dose of news here! Stay tuned for updates and upcoming features. The "beta" will soon be released and testing will begin. One everything gets ironed out, the real fun can begin, with widgets!</p>
                </div>
            </div>
        </div>
        <div id="project-selection" class="panel">
            <div id="project-holder" class="panel-holder">
            <div class="panel-label"><h5 >Stories</h5></div>
                <div id="main-project-holder" class="main-panel-holder">
                    <?php $user_obj->getProjects(); ?>
                    <a href="#" id="add-project-button" class="project new-project">New Project<i class="icon fas fa-plus"></i></a>
                </div>      
            </div>
        </div>
        <div id="new-project-window" class="panel">
            <div id="new-project-holder" class="panel-holder">
                <div class="panel-label"><h5 >Create A Project</h5></div>
                <div id="main-new-project-holder" class="main-panel-holder">
                    <form id="add-project-form" action="index.php" method="POST">
                        <input type="text" name="project_name" placeholder="Name" required/>
                        <input type="text" name="project_url_name" placeholder="URL Name" required/>
                        <p>Users</p>
                        <div id="owner" class="writer"><i class="fas fa-crown"></i><p><?php echo $userLoggedIn ?></p><p id="owner-text">Owner</p></div>
                        <div id="add-writer">
                            <a id="add-writer-button" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                        <a id="cancel-button">CANCEL</a>
                        <button name = "submit_button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="feed" class="panel">
            <div id="feed-holder" class="panel-holder">
                <div class="panel-label">
                    <h5>Friends</h5>
                    <div id="add-friend-border">
                        <a class="add-friend" id="add-friend" href="#"><i id="add-friend-icon" class="material-icons">add</i></a>
                        <input class="add-friend-input" id="add-friend-input" placeholder="Username">
                    </div>
                </div>
                
                <div id="add_friend">
                </div>
                <div id="main-feed-holder" class="main-panel-holder">

                </div>
            </div>
        </div>
    </div>


</body>
