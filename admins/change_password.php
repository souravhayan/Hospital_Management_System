<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

$error = '';
$success = '';

if (isset($_POST['change_password'])) {
    // Get and sanitize form inputs.
    $current_password = $conn->real_escape_string($_POST['current_password']);
    $new_password = $conn->real_escape_string($_POST['new_password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);
    
    // Retrieve the admin's details from the database.
    $username = $_SESSION['admin'];
    $result = $conn->query("SELECT * FROM Admin WHERE username = '$username'");
    
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        
        // Check if current password is correct (for plain text; replace with password_verify if using hashed passwords)
        if ($current_password != $admin['password']) {
            $error = "Current password is incorrect.";
        } elseif ($new_password != $confirm_password) {
            $error = "New password and confirm password do not match.";
        } else {
            // Update the password in the database.
            $update = $conn->query("UPDATE Admin SET password = '$new_password' WHERE username = '$username'");
            if ($update) {
                $success = "Password changed successfully.";
            } else {
                $error = "Failed to update password. Please try again.";
            }
        }
    } else {
        $error = "Admin data not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
</head>
<body>
    <h1>Change Password</h1>
    <?php if ($error != '') { echo "<p style='color:red;'>$error</p>"; } ?>
    <?php if ($success != '') { echo "<p style='color:green;'>$success</p>"; } ?>
    <form action="" method="post">
        <label>Current Password:</label>
        <input type="password" name="current_password" required><br><br>
        
        <label>New Password:</label>
        <input type="password" name="new_password" required><br><br>
        
        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br><br>
        
        <input type="submit" name="change_password" value="Change Password">
    </form>
    <br>
    <a href="../index.php">Back to Dashboard</a>
</body>
</html>
