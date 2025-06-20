<?php
session_start();
include '../db.php';
$error = '';

if (isset($_POST['login'])) {
    // Sanitize user input and check credentials
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Use plain text for now. Use password_hash in production.

    $query = "SELECT * FROM Admin WHERE username='$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if ($password == $admin['password']) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Invalid username.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Custom Styling -->
  <style>
    body {
      background: linear-gradient(120deg, #2196F3, #8E44AD);
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
    }
    .login-card {
      background: #ffffff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 1s ease-in-out;
      max-width: 400px;
      width: 100%;
    }
    .login-card h2 {
      color: #333;
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .form-label {
      font-weight: 600;
      color: #444;
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid #ddd;
      padding: 10px;
    }
    .btn-primary {
      background-color: #8E44AD;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      padding: 10px;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #5B2C6F;
    }
    .alert-danger {
      animation: slideIn 0.5s ease;
      margin-bottom: 15px;
      border-radius: 8px;
    }
    .login-card input:focus {
      border-color: #8E44AD;
      box-shadow: 0 0 8px rgba(142, 68, 173, 0.5);
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h2>Admin Login</h2>
    <?php if ($error != ""): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
