<div class="d-flex" id="wrapper">
  <!-- Sidebar-->
  <div class="border-end" id="sidebar-wrapper">
      <div class="sidebar-heading text-center py-4 fs-4 fw-bold">Hospital Management</div>
      <div class="list-group list-group-flush">
          <a href="../index.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-tachometer-alt me-2"></i>Dashboard
          </a>
          <a href="../departments/view_departments.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-building me-2"></i>Departments
          </a>
          <a href="../doctors/view_doctors.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-user-md me-2"></i>Doctors
          </a>
          <a href="../patients/view_patients.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-procedures me-2"></i>Patients
          </a>
          <a href="../appointments/view_appointments.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-calendar-check me-2"></i>Appointments
          </a>
          <a href="../medical_records/view_records.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-notes-medical me-2"></i>Medical Records
          </a>
          <a href="../billing/view_bills.php" class="list-group-item list-group-item-action bg-transparent">
              <i class="fas fa-file-invoice-dollar me-2"></i>Billing
          </a>
      </div>
  </div>
  <!-- Page content wrapper-->
  <div id="page-content-wrapper">
      <!-- Top navigation-->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
          <div class="container-fluid">
              <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                      <li class="nav-item">
                          <a class="nav-link" href="../admins/logout.php">
                              <i class="fas fa-sign-out-alt me-2"></i>Logout
                          </a>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
