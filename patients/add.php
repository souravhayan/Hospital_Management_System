<?php
// Include the common header and sidebar
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

$error = "";
$success = "";

if (isset($_POST['submit'])) {
    // Sanitize input values
    $first_name   = $conn->real_escape_string($_POST['first_name']);
    $last_name    = $conn->real_escape_string($_POST['last_name']);
    $dob          = $conn->real_escape_string($_POST['dob']);
    $gender       = $conn->real_escape_string($_POST['gender']);
    $blood_group  = $conn->real_escape_string($_POST['blood_group']);
    $contact_info = $conn->real_escape_string($_POST['contact_info']);
    $email        = $conn->real_escape_string($_POST['email']);
    $address      = $conn->real_escape_string($_POST['address']);

    $sql = "INSERT INTO Patients (first_name, last_name, dob, gender, blood_group, contact_info, email, address)
            VALUES ('$first_name','$last_name','$dob','$gender','$blood_group','$contact_info','$email','$address')";
    if ($conn->query($sql)) {
        $success = "Patient added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Add New Patient</h2>

    <?php if($error != ""): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if($success != ""): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="blood_group" class="form-label">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-select" required>
                <option value="" disabled selected>Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="Unknown">Unknown</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="contact_info" class="form-label">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email (Optional)</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address (Optional)</label>
            <textarea name="address" id="address" rows="3" class="form-control"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Add Patient
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
