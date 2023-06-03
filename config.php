<?php
$host = 'localhost';
$user = 'root';
$password = 'password';
$dbname = 'semicolondb';

// create connection
$conn = new mysqli($host, $user, $password, $dbname);

// check connection
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}
?>
