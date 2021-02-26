<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
include($_SERVER['DOCUMENT_ROOT'].'/Includes/header.php');
require $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/User.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/Piece.php');
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/Project.php');


$user_obj = new User($connection, $userLoggedIn);
$current_chapter;

if (isset($_GET['project_name'])) {
    $project_name = $_GET['project_name'];
    $project = new Project($connection, $project_name, $userLoggedIn);
    $current_chapter = $project->getCurrentChapter();
}

$projectID = $project->getID();
$username = $user_obj->getUsername();
$project_user_query = mysqli_query($connection, "SELECT * FROM project_user WHERE project='$projectID' AND username='$username'");
    //Get color
$project_user = mysqli_fetch_array($project_user_query);
$color = $project_user['color'];

if(isset($_POST['submit'])) {
    $piece = new Piece($connection, $userLoggedIn);
    //Find project_user obj
    
    $piece->submitPiece($_POST['piece_text'],$current_chapter->getID(),$color);
}

if(isset($_POST['delete'])) {
    $pieces = new Piece($connection, $userLoggedIn);
    $pieces->deletePiece();
}

if(isset($_POST['add_user'])) {
    $project->addUser($_POST['username_add']);
}
?>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Piece By Piece</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href='assets/css/project.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='assets/js/project.js'></script>
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
                <p><?php echo $project->getName(); ?></p>
                <hr>
                <a id="colorOpener" class="menuItem" href="#">Change Your Color</a>
                <a class="menuItem" href="#">Leave Project</a>
                <?php 
                if ($project->isOwner($userLoggedIn)) {
                    echo '<a class="menuItem" href="#">Manage Writers</a>';
                    echo '<a class="menuItem" href="#">Delete Project</a>';
                }
                ?>
                <hr>
                <a class="menuItem" href="index.php">Home</a>
                <a class="menuItem" href="release_notes.php">Release Notes</a>
                <a id="logoutButton" class="menuItem" href="Includes/handlers/logout.php">Log Out</a>
            </div>
        </div>
        <h2 class='title'><?php echo $project->getName(); ?></h2>
        <div id="writers">
            <!-- MAX AMOUNT OF WRITERS TO BE DISPLAYED IS 6 -->
            <i class="fas fa-crown"></i>
            <!-- <a class="owner writer" href="user/<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic']; ?>" alt=""></a> -->
            <?php $project->loadUsers(); ?>
            <a class="add_writer" id="add_writer" href="#"><i class="add_writer_icon fas fa-plus"></i></a>
            <div id="writer_search">
                <form action="<?php echo $_GET['project_name'] ?>" method="POST">
                    <input class="add_writer_input" name="username_add" type="text" placeholder="Username">
                    <button id="add_writer_button" name="add_user">ADD</button>
                </form>
            </div>
        </div>
    </div>

    <div id="colorChooser" class="popup">
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            <p>Choose Your Color:</p>
            <div class="color-grid">
                <div class="color-row">
                    <button style="background-color: #F6402B;" class="color"></button>
                    <button style="background-color: #EC1461" class="color"></button>
                    <button style="background-color: #9C1DB0" class="color"></button>
                    <button style="background-color: #6330B9" class="color"></button>
                    <button style="background-color: #3D4EB8" class="color"></button>
                </div>
                <div class="color-row">
                    <button style="background-color: #45AF4B" class="color"></button>
                    <button style="background-color: #029587" class="color"></button>
                    <button style="background-color: #00BAD6" class="color"></button>
                    <button style="background-color: #00A6F6" class="color"></button>
                    <button style="background-color: #1193F5" class="color"></button>
                </div>
                <div class="color-row">
                    <button style="background-color: #88C440" class="color"></button>
                    <button style="background-color: #CCDD25" class="color"></button>
                    <button style="background-color: #FEEC28" class="color"></button>
                    <button style="background-color: #FDC21E" class="color"></button>
                    <button style="background-color: #FF9914" class="color"></button>
                </div>
                <div class="color-row">
                    <button style="background-color: #FF5507" class="color"></button>
                    <button style="background-color: #795547" class="color"></button>
                    <button style="background-color: #9D9D9D" class="color"></button>
                    <button style="background-color: #5C7D8A" class="color"></button>
                    <button style="background-color: #242424" class="color"></button>
                </div>
            </div>
        </div>
    </div>

    <div id="story-frame">
        <div id="chapter-bar">
            <h5 id="chapter-text">Chapter Name</h5>
        </div>
        <div id="story-window">
            <?php 
                //$pieces = new Piece($connection, $userLoggedIn);
                $current_chapter->loadPieces();
            ?>
        </div>
    </div>
    <form class="content-form" action="<?php echo $_GET['project_name'] ?>" method="POST">
        <div class="content_input" id="content_field_holder">    
            <textarea style="border-color: <?php echo $color ?>" name="piece_text" class="content_input_field" id="content_input_field" placeholder="Write Something..." required></textarea>
        </div>
        <div id="buttons">
            <button name="submit" id="submit_button">Submit</button>
        </div>
    </form>


</body>


<script>
        var objDiv = document.getElementById("story-window");
        objDiv.scrollTop = objDiv.scrollHeight;
        var chapterID = "<?php echo $current_chapter->getID(); ?>";
        var username = "<?php echo $username; ?>";
        var projectID = "<?php echo $projectID; ?>";
        var projectName = "<?php echo $_GET['project_name']; ?>";

        var textareas = document.getElementsByTagName('textarea');
        var count = textareas.length;
        for(var i=0;i<count;i++){
            textareas[i].onkeydown = function(e){
                if(e.keyCode==9 || e.which==9){
                e.preventDefault();
                var s = this.selectionStart;
                this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
                this.selectionEnd = s+1; 
                }
            }
        }
    </script>
</html>