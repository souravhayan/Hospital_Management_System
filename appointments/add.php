<?php
// Include the common header, sidebar, and database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Retrieve active doctors and patients for dropdowns
$doctorQuery = "SELECT doctor_id, CONCAT('Dr. ', first_name, ' ', last_name) AS doctor_name FROM Doctors WHERE status='active'";
$doctorResult = $conn->query($doctorQuery);

$patientQuery = "SELECT patient_id, CONCAT(first_name, ' ', last_name) AS patient_name FROM Patients";
$patientResult = $conn->query($patientQuery);

$error = "";
$success = "";

if (isset($_POST['submit'])) {
    // Sanitize input values
    $doctor_id = $conn->real_escape_string($_POST['doctor_id']);
    $patient_id = $conn->real_escape_string($_POST['patient_id']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    $appointment_time = $conn->real_escape_string($_POST['appointment_time']);
    $reason = $conn->real_escape_string($_POST['reason']);
    $status = "scheduled"; // Default status for new appointments

    // Insert query
    $sql = "INSERT INTO Appointments (doctor_id, patient_id, appointment_date, appointment_time, reason, status)
            VALUES ('$doctor_id', '$patient_id', '$appointment_date', '$appointment_time', '$reason', '$status')";
    if ($conn->query($sql)) {
        $success = "Appointment added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Add New Appointment</h2>

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
                <option value="" disabled selected>Select Doctor</option>
                <?php while ($doctor = $doctorResult->fetch_assoc()) { ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                <option value="" disabled selected>Select Patient</option>
                <?php while ($patient = $patientResult->fetch_assoc()) { ?>
                    <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="appointment_time" class="form-label">Appointment Time</label>
            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" id="reason" rows="3" class="form-control"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Add Appointment
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
