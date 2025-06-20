<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admins/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Hospital Management System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    #wrapper {
      display: flex;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
    #sidebar-wrapper {
      min-width: 250px;
      max-width: 250px;
      background: linear-gradient(135deg, #343a40, #23272b);
      color: #fff;
      transition: all 0.3s ease;
    }

    #sidebar-wrapper .sidebar-heading {
      padding: 1.5rem;
      font-size: 1.5rem;
      background-color: #23272b;
      text-align: center;
    }

    #sidebar-wrapper .list-group-item {
      background-color: transparent;
      color: #ddd;
      border: none;
      transition: background-color 0.2s, color 0.2s;
    }

    #sidebar-wrapper .list-group-item:hover {
      background-color: #495057;
      color: #fff;
    }

    /* Toggled Sidebar */
    #wrapper.toggled #sidebar-wrapper {
      margin-left: -250px;
    }

    /* Page Content */
    #page-content-wrapper {
      flex: 1;
      transition: all 0.3s ease;
      padding: 20px;
    }

    .navbar {
      padding: 1rem;
      background: #ffffff;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card {
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .welcome-text {
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      #sidebar-wrapper {
        max-width: 200px;
      }

      #wrapper.toggled #sidebar-wrapper {
        margin-left: -200px;
      }
    }

    @media (max-width: 576px) {
      .navbar {
        padding: 0.5rem;
      }

      .card h5 {
        font-size: 1rem;
      }

      .card i {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
          <div class="sidebar-heading">Hospital Management</div>
          <div class="list-group list-group-flush">
              <a href="index.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-tachometer-alt me-2"></i>Dashboard
              </a>
              <a href="departments/view_departments.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-building me-2"></i>Departments
              </a>
              <a href="doctors/view_doctors.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-user-md me-2"></i>Doctors
              </a>
              <a href="patients/view_patients.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-procedures me-2"></i>Patients
              </a>
              <a href="appointments/view_appointments.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-calendar-check me-2"></i>Appointments
              </a>
              <a href="medical_records/view_records.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-notes-medical me-2"></i>Medical Records
              </a>
              <a href="billing/view_bills.php" class="list-group-item list-group-item-action">
                  <i class="fas fa-file-invoice-dollar me-2"></i>Billing
              </a>
          </div>
      </div>
      <!-- Page Content -->
      <div id="page-content-wrapper">
          <nav class="navbar navbar-expand-lg">
              <div class="container-fluid">
                  <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                      <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav ms-auto">
                          <li class="nav-item">
                              <a class="nav-link" href="admins/logout.php">
                                  <i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </nav>
          <div class="container-fluid">
              <h1 class="mt-4 welcome-text">Dashboard Home</h1>
              <p class="welcome-text">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong>! Use the sidebar to navigate through modules.</p>
              <div class="row mt-4 g-3">
                  <div class="col-md-3">
                      <div class="card text-white bg-primary shadow">
                          <div class="card-body text-center">
                              <h5 class="card-title">Departments</h5>
                              <i class="fas fa-building fa-3x"></i>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card text-white bg-success shadow">
                          <div class="card-body text-center">
                              <h5 class="card-title">Doctors</h5>
                              <i class="fas fa-user-md fa-3x"></i>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card text-white bg-warning shadow">
                          <div class="card-body text-center">
                              <h5 class="card-title">Appointments</h5>
                              <i class="fas fa-calendar-check fa-3x"></i>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card text-white bg-danger shadow">
                          <div class="card-body text-center">
                              <h5 class="card-title">Billing</h5>
                              <i class="fas fa-file-invoice-dollar fa-3x"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
      // Sidebar toggle animation
      document.getElementById("sidebarToggle").addEventListener("click", function () {
          document.getElementById("wrapper").classList.toggle("toggled");
      });
  </script>
</body>
</html>
