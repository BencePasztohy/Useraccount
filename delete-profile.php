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
        include('include/db-config.php');
        if (!isset($_SESSION['username'])) {
            $_SESSION['message'] = 'Not logged in.';
        } else {
            $username = $_SESSION['username'];
            $sql = "delete from users where username='$username'";
            if ($connection->query($sql) === TRUE) {
                $_SESSION['message'] = 'Profile ' . $username . ' deleted.';
                unset($_SESSION['username']);
            } else {
                echo 'Error deleting profile';
            }
        }
        include('include/header.php'); 
        ?>
    </header>
    <main>
        <?php 
            echo $_SESSION['message'];
            session_destroy();
        ?>
    </main>
</body>
</html>