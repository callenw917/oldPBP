<?php
include($_SERVER['DOCUMENT_ROOT'].'/Includes/classes/Chapter.php');

class Project {
    private $user_obj;
    private $project_obj;
    private $connection;

    public function __construct($connection, $name, $user){
        $this->connection = $connection;
        $this->user_obj = $user;
        $project_query = mysqli_query($connection, "SELECT * FROM projects WHERE url_name='$name'");
        $this->project_obj = mysqli_fetch_array($project_query);
    }

    // NO LONGER IN USE
    // public function newProject($connection, $name) {
    //     $name = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $name);
    //     $name = nl2br(strip_tags($name));
    //     $name = mysqli_real_escape_string($this->connection, $name);
    //     $check_empty = preg_replace('/\s+/', '', $name);

    //     if($check_empty != "") {
    //         $date_created = date("Y-m-d");
    //         $writer = $this->user_obj->getUsername();
    //         $query = mysqli_query($this->connection, "INSERT INTO projects VALUES('NULL',$name,1,0,$writer,1,$date_created)");
    //         $returned_id = mysqli_insert_id($this->connection);
    //     }
    // }

    public function getName() {
        return $this->project_obj['name'];
    }

    public function getOwner() {
        return $this->project_obj['owner'];
    }

    public function isOwner($username) {
        if ($username == $this->project_obj['owner']) {
            return true;
        } else {
            return false;
        }
    }

    public function getChapters() {
        return $this->project_obj['chapters'];
    }

    public function getChapterNum() {
        return $this->project_obj['currentChapter'];
    }

    public function getID() {
        return $this->project_obj['id'];
    }

    public function getCurrentChapter() {
        $id = $this->project_obj['id'];
        $chapter_query = mysqli_query($this->connection, "SELECT * FROM chapters WHERE project='$id' ORDER BY id DESC");
        $latest_chapter = mysqli_fetch_array($chapter_query);
        return new Chapter($this->connection,$latest_chapter['id'],$this->user_obj);
    }

    //ADD A RANDOM ARRAY OF COLORS AND AUTOMATICALLY ASSIGN ONE WHEN USER IS ADDED
    public function addUser($username) {
        $color_array = array("#F6402B","#EC1461","#9C1DB0","#6330B9","#3D4EB8","#45AF4B","#029587","#00BAD6","#00A6F6","#1193F5","#88C440","#CCDD25","#FEEC28","#FDC21E","#FF9914","#FF5507","#795547","#9D9D9D","#5C7D8A","#242424");
        $project_id = $this->project_obj['id'];
        //remove any colors if a user is already using it
        $color_query = mysqli_query($this->connection, "SELECT * FROM project_user WHERE project='$project_id'");
        while ($row = mysqli_fetch_array($color_query)) {
            for ($i = (sizeof($color_array) - 1); $i >= 0; $i--) {
                if ($row['color'] == $color_array[$i]) {
                    array_splice($color_array,$i,$i); 
                }
            }
        }
        $user_color_num = mt_rand(0,sizeof($color_array));
        $user_color = $color_array[$user_color_num];
        $user_query = mysqli_query($this->connection, "SELECT * FROM project_user WHERE project='$project_id' AND username='$username'");
        if (mysqli_num_rows($user_query) != 0) return;
        $user_query = mysqli_query($this->connection, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_fetch_array($user_query)) {
            $date_added = date("Y-m-d H:i:s");
            $add_user = mysqli_query($this->connection, "INSERT INTO project_user VALUES('','$project_id','$username','$user_color','','$date_added')");
        }
    }

    public function loadUsers() {
        $project_id = $this->project_obj['id'];
        $writer_query = mysqli_query($this->connection,"SELECT * FROM project_user WHERE project='$project_id'");
        $str ='';
        while ($row = mysqli_fetch_array($writer_query)) {
            if ($row['owner'] == "1") {
                $writer_username = $row['username'];
                $writer_color    = $row['color'];
                $writer_data_query = mysqli_query($this->connection,"SELECT * FROM users WHERE username='$writer_username'");
                $writer_data = mysqli_fetch_array($writer_data_query);
                $writer_pic = $writer_data['profile_pic'];
                $writer_fname = $writer_data['first_name'];
                $writer_lname = $writer_data['last_name'];
                $writer_name = $writer_fname . " " . $writer_lname;
                $str .= '<div id="writer_div"><a class="owner writer" href="user/' . $writer_username . '" style="border-color:' . $writer_color . '"><img src="' . $writer_pic . '" alt=""></a><div><span>' . $writer_name . '</span></div></div>';
            } else {
                $writer_username = $row['username'];
                $writer_color    = $row['color'];
                $writer_data_query = mysqli_query($this->connection,"SELECT * FROM users WHERE username='$writer_username'");
                $writer_data = mysqli_fetch_array($writer_data_query);
                $writer_pic = $writer_data['profile_pic'];
                $writer_fname = $writer_data['first_name'];
                $writer_lname = $writer_data['last_name'];
                $writer_name = $writer_fname . " " . $writer_lname;
                $str .= '<div id="writer_div"><a class="writer" href="user/' . $writer_username . '" style="border-color:' . $writer_color . '"><img src="' . $writer_pic . '" alt=""></a><div><span>' . $writer_name . '</span></div></div>';
            }
        }
        echo $str;
    }

}

?>