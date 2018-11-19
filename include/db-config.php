<?php
$server_name = 'localhost';
$server_username = 'root';
$server_password = '';
$server_database = 'useraccount';
$connection = mysqli_connect($server_name, $server_username, $server_password, $server_database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
    // echo "Connection successful." . "<br>";
}
?>