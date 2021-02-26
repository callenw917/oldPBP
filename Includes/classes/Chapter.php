<?php
class Chapter {
    private $user_obj;
    private $connection;
    private $chapter_obj;

    public function __construct($connection, $id, $user){
        $this->connection = $connection;
        $this->user_obj = $user;
        $chapter_query = mysqli_query($connection, "SELECT * FROM chapters WHERE id='$id'");
        $this->chapter_obj = mysqli_fetch_array($chapter_query);
    }

    public function newChapter($project, $name, $currentChapter) {
        $name = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $name);
        $name = nl2br(strip_tags($name));
        $name = mysqli_real_escape_string($this->connection, $name);
        $check_empty = preg_replace('/\s+/', '', $name);
        $chapter_num = $currentChapter + 1;

        if($check_empty != "") {
            $date_created = date("Y-m-d");
            $writer = $this->user_obj->getUsername();
            $query = mysqli_query($this->connection, "INSERT INTO chapters VALUES('NULL',$name,$project,'',0,$date_created,$chapter_num)");
            $returned_id = mysqli_insert_id($this->connection);
            $query = mysqli_query($this->connection, "UPDATE project SET chapterNumber='$chapter_num' WHERE id='$project'");
        }
    }

    public function getName() {
        return $this->chapter_obj['name'];
    }

    public function getID() {
        return $this->chapter_obj['id'];
    }

    public function loadPieces() {
        $id = $this->chapter_obj['id'];
        $pieces = mysqli_query($this->connection, "SELECT * FROM entries WHERE chapter='$id' AND deleted='0' ORDER BY id ASC");
        $str = "";
        while($row = mysqli_fetch_array($pieces)) {
            $id = $row['id'];
            $content = $row['content'];
            $writer = $row['user'];
            $color = $row['color'];
            $time = $row['time'];
            


            $time_now = date("Y-m-d H:i:s");
            $post_date = new DateTime($time);
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
            $str .= "<div class='piece_div'><p id='" . $id . "' style='border-left: .2vw outset " . $color . ";'>" . $content . "</p><form action='" . $_GET['project_name'] . "' method='POST'><button name='delete' id='delete' ><i class='fas fa-times'></i></button></form></div>";
        }
       
        echo $str;

        $date_loaded = date("Y-m-d H:i:s");
        $project_id = $this->chapter_obj['project'];
        $user = $this->user_obj;
        $writer_query = mysqli_query($this->connection,"SELECT * FROM project_user WHERE project='$project_id' AND username='$user'");
        $row = mysqli_fetch_array($writer_query);
        $project_userID = $row['id'];

        $update_loaded = mysqli_query($this->connection, "UPDATE project_user SET lastLoad='$date_loaded' WHERE id='$project_userID'");

    }

    
    
}

?>