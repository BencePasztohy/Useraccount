<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Sign Up</title>
</head>
<body>
<?php 

include('include/input-trimmer.php');
include('include/db-config.php');
?>
    <header>
        <?php 
        session_start();
        include('include/header.php'); 
        ?>
    </header>
    <main>
        <?php unset($_SESSION['loginfailed']); ?>
        <?php if(!isset($_POST['reg-username'])) { ?>
        <h1>Sign Up</h1>
        <form action="signup.php" method="post">
            <p class="input-text">Username:</p>
            <input type="text" name="reg-username" required autofocus>
            <p class="input-text">Email:</p>
            <input type="text" name="reg-email" required>
            <p class="input-text">New Password:</p>
            <input type="password" name="reg-password" required>
            <p class="input-text">Confirm Password:</p>
            <input type="password" name="reg-password-confirm" required>
            <br>
            <input type="submit" value="Sign Up" class="button">
        </form>
        <?php } else {
            $errors = [];
            $username = input_trimmer($_POST['reg-username']);
            if (empty($username)) {
                array_push($errors, 'No username specified.');
            } else {
                $check_user = "select username from users where username = '$username' limit 1";
                $result = mysqli_query($connection, $check_user);
                $result_array = mysqli_fetch_assoc($result);
                if ($result_array['username'] == $username) {
                    array_push($errors, 'Username already exists.');
                }
            }
            $email = input_trimmer($_POST['reg-email']);
            if (empty($email)) {
                array_push($errors, 'No email specified');
            } else {
                $check_email = "select email from users where email = '$email' limit 1";
                $result = mysqli_query($connection, $check_email);
                $result_array = mysqli_fetch_assoc($result);
                if ($result_array['email'] == $email) {
                    array_push($errors, 'Email already in use.');
                }
            }
            $password = input_trimmer($_POST['reg-password']);
            if (empty($password)) {
                array_push($errors, 'No password specified.');
            }
            $password_confirm = $_POST['reg-password-confirm'];
            if (empty($password_confirm)) {
                array_push($errors, 'No password-confirm specified.');
            } 
            if ($password != $password_confirm) {
                array_push($errors, 'Passwords don\'t mach.');
            }
            if (count($errors) < 1) {
                // echo "Inputs OK. <br>";
                // $password = md5($password); //encrypts pwds
                $sql = "insert into users (username, email, password) values ('$username', '$email', '$password')";
                if ($connection->query($sql) === TRUE) {
                    echo "Registration succesful. <br>";
                    echo '<br><a href="login.php" class="button">Log in</a>';
                } else {
                    echo "Error: " . $connection->error;
                }
            } else {
                echo '<h2 class="error">Error:</h2>';
                foreach($errors as $key => $val) {
                    echo $val . "<br>";
                }
                echo '<br><a href="signup.php" class="button">Back</a>';
            }
        } ?>
    </main>
</body>
</html>