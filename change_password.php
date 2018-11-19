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
<?php 
include('include/input-trimmer.php');
include('include/db-config.php');
?>
    <header>
        <?php include('include/header.php'); ?>
    </header>
    <main>
        <h1>Change password</h1>
<?php
$current_pwd = input_trimmer($_POST['current-password']);
$new_pwd = input_trimmer($_POST['new-password']);
$new_pwd_confirm = input_trimmer($_POST['new-password-confirm']);
$username = $_SESSION['username'];
$errors = [];
$sql = "select password from users where username='$username'";
$result = mysqli_query($connection, $sql);
$result_array = mysqli_fetch_assoc($result);
if ($result_array['password'] != $current_pwd) {
    array_push($errors, 'Incorrect current password.');
} else if ($new_pwd != $new_pwd_confirm) {
        array_push($errors, 'Passwords don\'t mach.');
    } else if ($current_pwd == $new_pwd) {
        array_push($errors, 'New password can\'t be the old password.');
    } else {
        $sql = "update users set password='$new_pwd' where username='$username'";
        if (mysqli_query($connection, $sql)) {
            echo 'Password updated successfully.<br><br>';
        } else {
            echo '<h2 class="error-header">Error</h2>';
        }
    }
    // echo '<h2 class="error-header">Error:</h2>';
    foreach($errors as $key => $val) {
        echo '<p class="error-messages">' . $val . '</p><br>';
    }
    echo '<a href="profile.php" class="button">Back</a>';
?>
    </main>
</body>
</html>