<?php
// Include the common header, sidebar, and database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Check for the patient ID in the URL
if (!isset($_GET['id'])) {
    header("Location: view_patients.php");
    exit;
}
$id = $_GET['id'];

// Retrieve the existing patient record
$query = "SELECT * FROM Patients WHERE patient_id='$id'";
$result = $conn->query($query);
if ($result->num_rows != 1) {
    die("Patient not found.");
}
$patient = $result->fetch_assoc();

$error = "";
$success = "";

if (isset($_POST['update'])) {
    // Sanitize input values
    $first_name   = $conn->real_escape_string($_POST['first_name']);
    $last_name    = $conn->real_escape_string($_POST['last_name']);
    $dob          = $conn->real_escape_string($_POST['dob']);
    $gender       = $conn->real_escape_string($_POST['gender']);
    $blood_group  = $conn->real_escape_string($_POST['blood_group']);
    $contact_info = $conn->real_escape_string($_POST['contact_info']);
    $email        = $conn->real_escape_string($_POST['email']);
    $address      = $conn->real_escape_string($_POST['address']);

    $sql = "UPDATE Patients SET 
                first_name='$first_name', 
                last_name='$last_name', 
                dob='$dob', 
                gender='$gender', 
                blood_group='$blood_group', 
                contact_info='$contact_info', 
                email='$email', 
                address='$address'
            WHERE patient_id='$id'";
    if ($conn->query($sql)) {
        $success = "Patient updated successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
    
    // Refresh the patient record data
    $query = "SELECT * FROM Patients WHERE patient_id='$id'";
    $result = $conn->query($query);
    $patient = $result->fetch_assoc();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Update Patient</h2>
    
    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $patient['first_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $patient['last_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $patient['dob']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="Male" <?php if($patient['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($patient['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($patient['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="blood_group" class="form-label">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-select" required>
                <option value="A+" <?php if($patient['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                <option value="A-" <?php if($patient['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                <option value="B+" <?php if($patient['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                <option value="B-" <?php if($patient['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                <option value="AB+" <?php if($patient['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                <option value="AB-" <?php if($patient['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                <option value="O+" <?php if($patient['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                <option value="O-" <?php if($patient['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                <option value="Unknown" <?php if($patient['blood_group'] == 'Unknown') echo 'selected'; ?>>Unknown</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="contact_info" class="form-label">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" class="form-control" value="<?php echo $patient['contact_info']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email (Optional)</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $patient['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address (Optional)</label>
            <textarea name="address" id="address" rows="3" class="form-control"><?php echo $patient['address']; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Patient
        </button>
        <a href="view_patients.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Patients List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
