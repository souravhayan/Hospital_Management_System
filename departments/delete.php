<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admins/login.php");
    exit;
}
include '../db.php';

if (!isset($_GET['id'])) {
    header("Location: view_departments.php");
    exit;
}
$id = $_GET['id'];
$sql = "DELETE FROM Departments WHERE dept_id='$id'";
if ($conn->query($sql)) {
    header("Location: view_departments.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
