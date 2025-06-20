<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Check if record ID is provided
if (!isset($_GET['id'])) {
    header("Location: view_records.php");
    exit;
}
$id = $_GET['id'];

// Retrieve current record details
$query = "SELECT * FROM MedicalRecords WHERE record_id='$id'";
$result = $conn->query($query);
if ($result->num_rows != 1) {
    die("Record not found.");
}
$record = $result->fetch_assoc();

// Retrieve patients
$patient_query = "SELECT patient_id, CONCAT(first_name, ' ', last_name) AS patient_name FROM Patients";
$patient_result = $conn->query($patient_query);

// Retrieve doctors
$doctor_query = "SELECT doctor_id, CONCAT('Dr. ', first_name, ' ', last_name) AS doctor_name FROM Doctors WHERE status='active'";
$doctor_result = $conn->query($doctor_query);

// Retrieve appointments
$appointment_query = "SELECT appointment_id, CONCAT(appointment_date, ' ', appointment_time) AS appointment_dt FROM Appointments";
$appointment_result = $conn->query($appointment_query);

$error = "";
$success = "";

if (isset($_POST['update'])) {
    // Sanitize input values
    $patient_id = $conn->real_escape_string($_POST['patient_id']);
    $doctor_id = $conn->real_escape_string($_POST['doctor_id']);
    $appointment_id = isset($_POST['appointment_id']) && $_POST['appointment_id'] !== "" ? $conn->real_escape_string($_POST['appointment_id']) : null;
    $visit_date = $conn->real_escape_string($_POST['visit_date']);
    $diagnosis = $conn->real_escape_string($_POST['diagnosis']);
    $prescribed_medication = $conn->real_escape_string($_POST['prescribed_medication']);
    $treatment = $conn->real_escape_string($_POST['treatment']);
    $notes = $conn->real_escape_string($_POST['notes']);

    $sql = $appointment_id === null ? 
        "UPDATE MedicalRecords SET 
            patient_id='$patient_id', 
            doctor_id='$doctor_id', 
            visit_date='$visit_date', 
            diagnosis='$diagnosis', 
            prescribed_medication='$prescribed_medication', 
            treatment='$treatment', 
            notes='$notes',
            appointment_id=NULL
        WHERE record_id='$id'" 
        : 
        "UPDATE MedicalRecords SET 
            patient_id='$patient_id', 
            doctor_id='$doctor_id', 
            appointment_id='$appointment_id', 
            visit_date='$visit_date', 
            diagnosis='$diagnosis', 
            prescribed_medication='$prescribed_medication', 
            treatment='$treatment', 
            notes='$notes'
        WHERE record_id='$id'";

    if ($conn->query($sql)) {
        $success = "Medical record updated successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }

    // Refresh the record
    $query = "SELECT * FROM MedicalRecords WHERE record_id='$id'";
    $result = $conn->query($query);
    $record = $result->fetch_assoc();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Update Medical Record</h2>

    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                <option value="" disabled>Select Patient</option>
                <?php while ($patient = $patient_result->fetch_assoc()) { ?>
                    <option value="<?php echo $patient['patient_id']; ?>" <?php if ($patient['patient_id'] == $record['patient_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($patient['patient_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                <option value="" disabled>Select Doctor</option>
                <?php while ($doctor = $doctor_result->fetch_assoc()) { ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>" <?php if ($doctor['doctor_id'] == $record['doctor_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($doctor['doctor_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="appointment_id" class="form-label">Appointment (Optional)</label>
            <select name="appointment_id" id="appointment_id" class="form-select">
                <option value="">None</option>
                <?php while ($appointment = $appointment_result->fetch_assoc()) { ?>
                    <option value="<?php echo $appointment['appointment_id']; ?>" <?php if ($appointment['appointment_id'] == $record['appointment_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($appointment['appointment_dt']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="visit_date" class="form-label">Visit Date</label>
            <input type="date" name="visit_date" id="visit_date" class="form-control" value="<?php echo htmlspecialchars($record['visit_date']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnosis</label>
            <input type="text" name="diagnosis" id="diagnosis" class="form-control" value="<?php echo htmlspecialchars($record['diagnosis']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="prescribed_medication" class="form-label">Prescribed Medication</label>
            <input type="text" name="prescribed_medication" id="prescribed_medication" class="form-control" value="<?php echo htmlspecialchars($record['prescribed_medication']); ?>">
        </div>
        <div class="mb-3">
            <label for="treatment" class="form-label">Treatment</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3"><?php echo htmlspecialchars($record['treatment']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="2"><?php echo htmlspecialchars($record['notes']); ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Record
        </button>
        <a href="view_records.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Records List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
