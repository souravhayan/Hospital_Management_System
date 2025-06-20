<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Initialize the search query
$searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Query to retrieve appointments filtered by the search query
$query = "SELECT a.*, 
                 CONCAT('Dr. ', d.first_name, ' ', d.last_name) AS doctor_name, 
                 CONCAT(p.first_name, ' ', p.last_name) AS patient_name 
          FROM Appointments a
          LEFT JOIN Doctors d ON a.doctor_id = d.doctor_id
          LEFT JOIN Patients p ON a.patient_id = p.patient_id
          WHERE a.appointment_id LIKE '%$searchQuery%' 
             OR d.first_name LIKE '%$searchQuery%' 
             OR d.last_name LIKE '%$searchQuery%' 
             OR p.first_name LIKE '%$searchQuery%' 
             OR p.last_name LIKE '%$searchQuery%' 
             OR a.status LIKE '%$searchQuery%' 
          ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$result = $conn->query($query);
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Appointments List</h2>
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by ID, Doctor, Patient, or Status" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus me-1"></i>Add New Appointment
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo htmlspecialchars($row['appointment_id']); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="delete.php?id=<?php echo htmlspecialchars($row['appointment_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="../index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
