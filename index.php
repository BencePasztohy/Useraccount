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
                <input type="text" name="title" class="post-writer-field" required>
                <textarea name="post" cols="62" rows="2" maxlength="1024" class="post-writer-field" required></textarea>
                <input type="submit" value="Post" class="button submit-post">
            </form>
        <?php } ?>
        <?php
        if(isset($_POST['post'])) {
            $title = input_trimmer($_POST['title']);
            $text = input_trimmer($_POST['post']);
            $poster = $_SESSION['username'];
            $date = date("Y\-m\-j\-G\-i\-s"); //saves the current date as YYYY-MM-DD-HH-MM-SS
            $sql = "insert into posts (title, text, poster, date) values ('$title', '$text', '$poster', '$date')";
            if($connection->query($sql) === TRUE) {
                header('Location: index.php');
            } else {
                //do nothing
            }
         
        } else {
            //do nothing
        }
        ?>
        </div>
        
<?php
unset($_SESSION['loginfailed']); 
//if after a failed login the user navigates away from the login page then back, this clears the 'login failed' message on he login page

$sql = "select title, text, poster, date from posts order by date desc";
$result = mysqli_query($connection, $sql);
$posts = [];
foreach($result as $key => $val) {
    array_push($posts, $val);
}
foreach($posts as $key => $val) {
    if ($val['date']) {
        $display_date = substr($val['date'], 0, 10);
        //in the database the date it stored to the second, but php will only display it to the day to make it look clearer
    }
    echo '<div class="post">
        <div class="post-header">
            <span class="post-title">' . $val["title"] . '</span>
            <span class="post-poster">' . $val["poster"] . '</span>
            <p class="post-date">' . $display_date . '</p>
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
            <span class="post-title">Template Post Title</span>
            <span class="post-poster">Template Poster</span>
            <p class="post-date">Template 2018-11-19</p>
        </div>
        
        <hr>
        <div class="post-body">
            <p>Template Post text. Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis in architecto quod molestiae, fugit voluptatibus tempore pariatur adipisci ducimus perferendis?</p>
        </div>
    </div> -->

    <!-- End of post template -->

    </main>
</body>
</html>