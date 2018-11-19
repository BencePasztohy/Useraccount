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
        ?>
    </header>
    <main>
        <h1>Main Page</h1>
<?php
unset($_SESSION['loginfailed']); 
//if after a failed login the user navigates away from the login page then back, this clears the 'login failed' message on he login page

include('include/db-config.php');
$sql = "select title, text, poster, date from posts order by date desc";
$result = mysqli_query($connection, $sql);
$posts = [];
foreach($result as $key => $val) {
    array_push($posts, $val);
}
foreach($posts as $key => $val) {
    echo '<div class="post">
        <div class="post-header">
            <span class="post-title">' . $val["title"] . '</span>
            <span class="post-poster">' . $val["poster"] . '</span>
            <p class="post-date">' . $val["date"] . '</p>
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
            <span class="post-title">Post Title</span>
            <span class="post-poster">Poster</span>
            <p class="post-date">2018-11-19</p>
        </div>
        
        <hr>
        <div class="post-body">
            <p>Post text. Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis in architecto quod molestiae, fugit voluptatibus tempore pariatur adipisci ducimus perferendis?</p>
        </div>
    </div> -->

    <!-- End of post template -->

    </main>
</body>
</html>