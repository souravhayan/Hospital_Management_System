<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Check for appointment ID in the URL
if (!isset($_GET['id'])) {
    header("Location: view_appointments.php");
    exit;
}
$id = $_GET['id'];

// Retrieve current appointment details
$query = "SELECT * FROM Appointments WHERE appointment_id='$id'";
$result = $conn->query($query);
if ($result->num_rows != 1) {
    die("Appointment not found.");
}
$appointment = $result->fetch_assoc();

// Retrieve doctors and patients for dropdowns
$doctorQuery = "SELECT doctor_id, CONCAT('Dr. ', first_name, ' ', last_name) AS doctor_name FROM Doctors WHERE status='active'";
$doctorResult = $conn->query($doctorQuery);

$patientQuery = "SELECT patient_id, CONCAT(first_name, ' ', last_name) AS patient_name FROM Patients";
$patientResult = $conn->query($patientQuery);

$error = "";
$success = "";

if (isset($_POST['update'])) {
    // Sanitize input values
    $doctor_id = $conn->real_escape_string($_POST['doctor_id']);
    $patient_id = $conn->real_escape_string($_POST['patient_id']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    $appointment_time = $conn->real_escape_string($_POST['appointment_time']);
    $reason = $conn->real_escape_string($_POST['reason']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update query
    $sql = "UPDATE Appointments SET 
                doctor_id='$doctor_id', 
                patient_id='$patient_id', 
                appointment_date='$appointment_date', 
                appointment_time='$appointment_time', 
                reason='$reason', 
                status='$status'
            WHERE appointment_id='$id'";
    if ($conn->query($sql)) {
        $success = "Appointment updated successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }

    // Refresh data
    $query = "SELECT * FROM Appointments WHERE appointment_id='$id'";
    $result = $conn->query($query);
    $appointment = $result->fetch_assoc();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Update Appointment</h2>

    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                <option value="" disabled>Select Doctor</option>
                <?php while ($doctor = $doctorResult->fetch_assoc()) { ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>" <?php if ($doctor['doctor_id'] == $appointment['doctor_id']) echo 'selected'; ?>>
                        <?php echo $doctor['doctor_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                <option value="" disabled>Select Patient</option>
                <?php while ($patient = $patientResult->fetch_assoc()) { ?>
                    <option value="<?php echo $patient['patient_id']; ?>" <?php if ($patient['patient_id'] == $appointment['patient_id']) echo 'selected'; ?>>
                        <?php echo $patient['patient_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo $appointment['appointment_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="appointment_time" class="form-label">Appointment Time</label>
            <input type="time" name="appointment_time" id="appointment_time" class="form-control" value="<?php echo $appointment['appointment_time']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" id="reason" rows="3" class="form-control"><?php echo $appointment['reason']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="scheduled" <?php if ($appointment['status'] == 'scheduled') echo 'selected'; ?>>Scheduled</option>
                <option value="completed" <?php if ($appointment['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                <option value="cancelled" <?php if ($appointment['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                <option value="no_show" <?php if ($appointment['status'] == 'no_show') echo 'selected'; ?>>No Show</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Appointment
        </button>
        <a href="view_appointments.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Appointments List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
