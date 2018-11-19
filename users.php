<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Users</title>
</head>
<body>
    <header>
    <?php 
        session_start();
        include('include/header.php'); 
        ?>
    </header>
    <main>
        <h1>List of users</h1>
<?php
unset($_SESSION['loginfailed']);

if (isset($_SESSION['username'])) {
    include('include/db-config.php');
    $sql = 'select username from users';
    $result = mysqli_query($connection, $sql);
    $usernames = [];
    foreach($result as $key => $val) {
        foreach($val as $key => $val2) {
            array_push($usernames, $val2);
        }
    }
    $sql = 'select email from users';
    $result = mysqli_query($connection, $sql);
    $emails = [];
    foreach($result as $key => $val) {
        foreach($val as $key => $val2) {
            array_push($emails, $val2);
        }
    }
    ?>
    <table class="users-table">
        <tr>
            <th>Username</th>
            <th>Email</th>
        </tr>
    <?php 
        for ($i=0; $i < sizeof($usernames); $i++) { 
            echo '
                <tr>
                    <td>
            ';
            echo $usernames[$i];
            echo '</td><td>';
            echo $emails[$i];
            echo '
                    </td>
                </tr>
            ';
            
        }
        echo '</table>';
    
} else {
    echo 'Only logged in users have access.';
}
?>
    </main>
</body>
</html>