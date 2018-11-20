<?php
include('include/db-config.php');
include('include/input-trimmer.php');
$id = input_trimmer($_GET['id']);
$sql = "delete from posts where id ='$id'";
if ($connection->query($sql) === TRUE) {
    echo 'deleted';
} else echo 'error';
?>