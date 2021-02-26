<?php
class User {
    private $user;
    private $connection;
    private $username;

    public function __construct($connection, $user){
        $this->connection =$connection;
        $user_details_query = mysqli_query($connection, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
        $this->username = $user;
    }

    public function getFirstName() {
        return $this->user['first_name']; 
    }
    public function getLastName() {
        return $this->user['last_name']; 
    }
    public function getUsername() {
        return $this->user['username'];
    }
    public function getColor() {
        return $this->user['color']; 
    }
    public function getNumPosts() {
        return $this->user['num_posts'];
    }
    public function getID() {
        return $this->user['id'];
    }

    public function getProjects() {
        $str = "";
        $project_query = mysqli_query($this->connection, "SELECT * FROM `project_user` WHERE username='$this->username' ORDER BY id ASC");
        if (!$project_query) {
            printf("Error: %s\n", mysqli_error($this->connection));
            exit();
        }
        while($row = mysqli_fetch_array($project_query)) {
            //row is project_user value
            //project is the actual project
            $projectID = $row['project'];
            $data = mysqli_query($this->connection, "SELECT * FROM projects WHERE id='$projectID'");
            $project = mysqli_fetch_array($data);
            $name = $project['name'];
            $urlName = $project['url_name'];
            //$owner = $project['owner'];
            //$dateCreated = $project['date_created'];
            //$color = $row['color'];
            $lastLoad = $row['lastLoad'];

            //REPLACE THIS WITH CURRENT CHAPTER FROM PROJECT DATABASE EVENTUALLY
            $chapter_query = mysqli_query($this->connection, "SELECT * FROM chapters WHERE project='$projectID' ORDER BY id DESC");
            $latest_chapter = mysqli_fetch_array($chapter_query);
            $chapterID = $latest_chapter['id'];


            $numUnread = 0;
            $piece_query = mysqli_query($this->connection, "SELECT * FROM entries WHERE chapter='$chapterID'");
            while($chapterRow = mysqli_fetch_array($piece_query)) {
                $dateCreated = $chapterRow['time'];
                if ($lastLoad < $dateCreated) {
                    $numUnread++;
                }
            }
            if ($numUnread != 0) {
                $str .= "<a href='/" . $urlName . "' class='project'>" . $name . "<span class='num-unread'>" . $numUnread . "</span><i class='icon fas fa-chevron-right'></i></a>";
            } else {
                $str .= "<a href='/" . $urlName . "' class='project'>" . $name . "<i class='icon fas fa-chevron-right'></i></a>";
            }
        }
       
        echo $str;
    }
}

?>