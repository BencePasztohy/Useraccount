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
    
    <main>
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
    </main>
<?php } ?>
<script src="js/main.js"></script>
</body>
</html>