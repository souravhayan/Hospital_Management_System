<?php
// Include common files
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
    $doctor_id       = $conn->real_escape_string($_POST['doctor_id']);
    $patient_id      = $conn->real_escape_string($_POST['patient_id']);
    $visit_date      = $conn->real_escape_string($_POST['visit_date']);
    $diagnosis       = $conn->real_escape_string($_POST['diagnosis']);
    $treatment       = $conn->real_escape_string($_POST['treatment']);
    $prescription    = $conn->real_escape_string($_POST['prescription']);
    $notes           = $conn->real_escape_string($_POST['notes']);

    // Insert query
    $sql = "INSERT INTO MedicalReports (doctor_id, patient_id, visit_date, diagnosis, treatment, prescription, notes)
            VALUES ('$doctor_id', '$patient_id', '$visit_date', '$diagnosis', '$treatment', '$prescription', '$notes')";
    if ($conn->query($sql)) {
        $success = "Medical report added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Add New Medical Report</h2>

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
            <label for="visit_date" class="form-label">Visit Date</label>
            <input type="date" name="visit_date" id="visit_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnosis</label>
            <textarea name="diagnosis" id="diagnosis" rows="3" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="treatment" class="form-label">Treatment</label>
            <textarea name="treatment" id="treatment" rows="3" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="prescription" class="form-label">Prescription</label>
            <textarea name="prescription" id="prescription" rows="3" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Add Medical Report
        </button>
        <a href="view_reports.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Medical Reports List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
