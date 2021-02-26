<?php
class Piece {
    private $user_obj;
    private $connection;

    public function __construct($connection, $user){
        $this->connection =$connection;
        $this->user_obj = new User($connection, $user);
    }

    public function submitPiece($content, $chapter, $color) {
        $content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $content);
        $content = nl2br(strip_tags($content));
        $content = mysqli_real_escape_string($this->connection, $content);
        $check_empty = preg_replace('/\s+/', '', $content);

        if($check_empty != "") {
            $date_added = date("Y-m-d H:i:s");

            $writer = $this->user_obj->getUsername();
            $query = mysqli_query($this->connection, "INSERT INTO entries VALUES('$chapter','$writer','$color','$content', '0','$date_added','NULL')");
            $returned_id = mysqli_insert_id($this->connection);

            //Post notification

            //Update post counter
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->connection, "UPDATE users SET num_posts='$num_posts' WHERE username='$writer'");
            $_SESSION['latest_entry'] = $returned_id;
        }
    }

    public function deletePiece() {
        
        $latest_entry = $_SESSION['latest_entry'];

        $delet_query = mysqli_query($this->connection, "UPDATE entries SET deleted='1' WHERE id='$latest_entry'");

        $data = mysqli_query($this->connection, "SELECT * FROM entries WHERE deleted='0' ORDER BY id ASC");

        while($row = mysqli_fetch_array($data)) {}
        $_SESSION['latest_entry'] = $row['id'];
    }

    public function loadPieces() {
        $str = "";
        $data = mysqli_query($this->connection, "SELECT * FROM entries WHERE deleted='0' ORDER BY id ASC");

        while($row = mysqli_fetch_array($data)) {
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
            $str .= "<div class='piece_div'><p id='" . $id . "' style='border-left: .2vw outset " . $color . ";'>" . $content . "</p><form action='index.php' method='POST'><button name='delete' id='delete_piece'><i class='fas fa-minus-square'></i></button></form></div>";
        }
       
        echo $str;
    }
}

?>