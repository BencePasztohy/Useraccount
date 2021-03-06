<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Main Page</title>
</head>
<body>
    <header>
    <?php 
        session_start();
        include('include/header.php'); 
        include('include/db-config.php');
        include('include/input-trimmer.php');
        ?>
    </header>
    <main>
        <h1>Main Page</h1>
        <?php if(isset($_SESSION['username'])) { ?>
        <div class="post-writer">
            <span class="post-writer-title">Write post</span>
            <form action="index.php" method="post">
                <div class="title-div">
                    <!-- <input type="text" name="title" class="post-writer-field" id="title-input" required> -->
                    <textarea name="title" rows="1" maxlength="512" class="post-writer-field" id="title-input" required></textarea>
                    <p id="title-counter"></p>
                </div>
                <div class="text-div">
                    <textarea name="post" rows="2" maxlength="1024" class="post-writer-field" id="text-input" required></textarea>
                    <p id="post-counter"></p>
                </div>
                
                <input type="submit" value="Post" class="button submit-post">
            </form>
        <?php } ?>
        <?php
        if(isset($_POST['post'])) {
            $title = input_trimmer($_POST['title']);
            $temp_title = trim($title, ' ');
            $text = input_trimmer($_POST['post']);
            $temp_text = trim($text, ' ');
            if ($temp_title == '') {
                unset($_POST['title']);
                header('Location: index.php');
            } else if ($temp_text == '') {
                unset($_POST['post']);
                header('Location: index.php');
            } else {
                $poster = $_SESSION['username'];
                $date = date("Y\-m\-j\-G\-i\-s"); //saves the current date as YYYY-MM-DD-HH-MM-SS
                $sql = "insert into posts (title, text, poster, date) values ('$title', '$text', '$poster', '$date')";
                if($connection->query($sql) === TRUE) {
                    header('Location: index.php');
                    //this reloads the page and clears all $_POST variables
                } else {
                    //do nothing
                }
            }
            
         
        } else {
            //do nothing
        }
        ?>
        </div>
        
<?php
unset($_SESSION['loginfailed']); 
//if after a failed login the user navigates away from the login page then back, this clears the 'login failed' message on he login page

$sql = "select id, title, text, poster, date from posts order by date desc";
$result = mysqli_query($connection, $sql);
$posts = [];
foreach($result as $key => $val) {
    array_push($posts, $val);
}
foreach($posts as $key => $val) {
    if ($val['date']) {
        $display_date = substr($val['date'], 0, 10);
        //in the database the date it stored to the second, but php will only display it to the day to make it look cleaner on the page
    }
    echo '<div class="post">
        <div class="post-header">
            <div class="title-and-delete">
                <span class="post-title">' . $val["title"] . '</span>';
                if (isset($_SESSION['username']) && $val['poster'] == $_SESSION['username']) echo '<span id="post-delete" onClick="deletePost(' . $val["id"] . ')">delete</span>';
                //only display delete button if loggen in and logged in user wrote the post
            echo '</div>
            <div class="date-and-poster">
                <span class="post-poster">' . $val["poster"] . '</span>
                <span class="post-date">' . $display_date . '</span>
            </div>
        </div>
        
        <hr>
        <div class="post-body">
            <p>' . $val["text"] . '</p>
        </div>
    </div>';
}
?>

    <!-- Start of post template -->

    <!-- <div class="post">
        <div class="post-header">
            <div class="title-and-delete">
                <span class="post-title">Template Post Title</span>
                <span id="post-delete">delete</span>
            </div>
            <div class="date-and-poster">
                <span class="post-poster">Template Poster</span>
                <span class="post-date">Template 2018-11-19</span>
            </div>
        </div>
        
        <hr>
        <div class="post-body">
            <p>Template Post text. </p>
        </div>
    </div> -->

    <!-- End of post template -->

    </main>
    <script src="js/main.js"></script>
</body>
</html>