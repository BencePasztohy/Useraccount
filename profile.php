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
<?php 
unset($_SESSION['loginfailed']);
include('include/db-config.php');
if (!isset($_SESSION['username'])) {
    ?>
    <main>
        <p>Only logged in users can see this page.</p>
        <a href="login.php" class="button">Log In</a>
        <a href="signup.php" class="button">Sign Up</a>
    </main>
    <?php
} else {
    $username = $_SESSION['username'];

    $sql = "select email from users where username='$username'";
    $result = mysqli_query($connection, $sql);
    $assoc = mysqli_fetch_assoc($result);
    foreach($assoc as $key =>$val) {
        $email = $val;
    }
    $sql = "select password from users where username='$username'";
    $result = mysqli_query($connection, $sql);
    $assoc = mysqli_fetch_assoc($result);
    foreach($assoc as $key =>$val) {
        $password = $val;
    }
?>
    
    <main class="flexbox">
        <div class="left">
            <h1>User Profile</h1>
            <p>Username: <?php echo $username; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <span>Current password: </span>
            <span id="hidden-pwd">
            <?php 
                $hidden_pwd = '';
                for ($i=0; $i < strlen($password); $i++) { 
                    $hidden_pwd = $hidden_pwd . '*';
                }
                echo $hidden_pwd;
            ?></span>
            <span class="show-pwd" id="show-pwd" onClick="showPwd('<?php echo $password; ?>', '<?php echo $hidden_pwd; ?>')"> show</span>
            <h2>New Password:</h2>
            <form action="change_password.php" method="post">
                <p class="input-text">Current password:</p>
                <input type="password" name="current-password" required>
                <p class="input-text">New password:</p>
                <input type="password" name="new-password" required>
                <p class="input-text">Confirm new password:</p>
                <input type="password" name="new-password-confirm" required>
                <br>
                <input type="submit" value="Update" class="button">
            </form>
            <br>
            <span class="delete-profile-link" onClick="deleteProfile()">Delete profile</span>
        </div>
        <div class="right">
            <h1>Posts</h1>
            <?php
            $sql = "select id, title, text, poster, date from posts where poster='$username' order by date desc ";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) < 1) {
                echo "There are no posts to show.";
            } else {
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
                            <span class="post-title">' . $val["title"] . '</span>
                            <span id="post-delete" onClick="deletePost(' . $val["id"] . ')">delete</span>
                            </div>
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
            }
            
            ?>
        </div>
    </main>
<?php } ?>
<script src="js/main.js"></script>
</body>
</html>