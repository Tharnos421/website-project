<?php
$host = 'localhost';
$dbname = 'finalproject';
$username = 'root';
$password = '';

$con = new mysqli($host, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>