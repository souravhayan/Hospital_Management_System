<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hospitalDB';

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
