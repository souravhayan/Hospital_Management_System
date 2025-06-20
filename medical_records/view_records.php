<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Initialize the search query
$searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Query to retrieve medical records filtered by search criteria
$query = "SELECT mr.*, 
                 CONCAT(p.first_name, ' ', p.last_name) AS patient_name, 
                 CONCAT('Dr. ', d.first_name, ' ', d.last_name) AS doctor_name, 
                 a.appointment_date, a.appointment_time 
          FROM MedicalRecords mr
          LEFT JOIN Patients p ON mr.patient_id = p.patient_id
          LEFT JOIN Doctors d ON mr.doctor_id = d.doctor_id
          LEFT JOIN Appointments a ON mr.appointment_id = a.appointment_id
          WHERE mr.record_id LIKE '%$searchQuery%' 
             OR p.first_name LIKE '%$searchQuery%' 
             OR p.last_name LIKE '%$searchQuery%' 
             OR d.first_name LIKE '%$searchQuery%' 
             OR d.last_name LIKE '%$searchQuery%' 
             OR mr.visit_date LIKE '%$searchQuery%' 
          ORDER BY mr.visit_date DESC";
$result = $conn->query($query);
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Medical Records List</h2>
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Record ID, Patient, Doctor, or Visit Date" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus me-1"></i>Add New Record
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Visit Date</th>
                <th>Diagnosis</th>
                <th>Medication</th>
                <th>Treatment</th>
                <th>Notes</th>
                <th>Appointment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['record_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['visit_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
                    <td><?php echo htmlspecialchars($row['prescribed_medication']); ?></td>
                    <td><?php echo htmlspecialchars($row['treatment']); ?></td>
                    <td><?php echo htmlspecialchars($row['notes']); ?></td>
                    <td>
                        <?php 
                        if (!empty($row['appointment_date'])) {
                            echo htmlspecialchars($row['appointment_date']) . " " . htmlspecialchars($row['appointment_time']);
                        } else {
                            echo "--";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="update.php?id=<?php echo htmlspecialchars($row['record_id']); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="delete.php?id=<?php echo htmlspecialchars($row['record_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">No medical records found.</td>
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
