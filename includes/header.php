<?php
// header.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admins/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hospital Management System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Wrapper style */
    #wrapper {
      display: flex;
      width: 100%;
    }
    /* Sidebar */
    #sidebar-wrapper {
      min-width: 250px;
      max-width: 250px;
      background-color: #343a40 !important; /* Dark background */
      color: #fff;
      transition: all 0.3s;
      height: 100vh; /* Force the sidebar to full viewport height */
    }
    #sidebar-wrapper .sidebar-heading {
      padding: 1.25rem 1rem;
      font-size: 1.25rem;
      background-color: #23272b !important;
    }
    #sidebar-wrapper .list-group-item {
      background-color: #343a40 !important;
      border: none;
      color: #ddd !important;
    }
    #sidebar-wrapper .list-group-item:hover {
      background-color: #495057 !important;
      color: #fff;
    }
    /* Page content */
    #page-content-wrapper {
      width: 100%;
      padding: 20px;
    }
    /* Toggled sidebar */
    #wrapper.toggled #sidebar-wrapper {
      margin-left: -250px;
    }
    /* Top Navbar override if needed */
    .navbar {
      padding: 0.75rem 1rem;
    }
  </style>
</head>
<body>
