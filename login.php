<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Log In</title>
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
        <?php if (!isset($_POST['log-username'])) { ?>
        <h1>Log In</h1>
        <form action="login.php" method="post">
            <p class="input-text">Username:</p>
            <input type="text" name="log-username" required autofocus>
            <p class="input-text">Password:</p>
            <input type="password" name="log-password" required>
            <br>
            <input type="submit" value="Log in" class="button">
            <?php if (isset($_SESSION['loginfailed'])) {
                echo '<p class="error">Wrong username or password.<br></p>';
            } ?>
        </form>
        <?php } else { 
            
            $errors = [];
            $username = input_trimmer($_POST['log-username']);
            if (empty($username)) {
                array_push($errors, 'No username specified.');
            }
            $password = input_trimmer($_POST['log-password']);
            if (empty($password)) {
                array_push($errors, 'No password specified.');
            }
            if (count($errors) < 1) {
                $query = "select username, password from users where username =  '$username' and password = '$password'";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) == 1) {
                    echo "Logged in.";
                    $_SESSION['username'] = $username;
                    header('Location: index.php');
                } else {
                    $_SESSION['loginfailed'] = true;
                    header('Refresh:0');
                }
            } else {
                echo '<h2 class="error">Error:</h2>';
                foreach($errors as $key => $val) {
                    echo $val . "<br>";
                }
            }
        }
        ?>
    </main>
</body>
</html>