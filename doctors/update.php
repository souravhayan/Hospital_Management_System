<?php
// Include the common header, sidebar, and database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Check for the doctor ID in the URL
if (!isset($_GET['id'])) {
    header("Location: view_doctors.php");
    exit;
}
$id = $_GET['id'];

// Retrieve the existing doctor's record
$query = "SELECT * FROM Doctors WHERE doctor_id='$id'";
$result = $conn->query($query);
if ($result->num_rows != 1) {
    die("Doctor not found.");
}
$doctor = $result->fetch_assoc();

// Retrieve active departments for the dropdown
$deptQuery = "SELECT dept_id, name FROM Departments WHERE status='active'";
$deptResult = $conn->query($deptQuery);

$error = "";
$success = "";

if (isset($_POST['update'])) {
    // Sanitize input values
    $dept_id       = $conn->real_escape_string($_POST['dept_id']);
    $first_name    = $conn->real_escape_string($_POST['first_name']);
    $last_name     = $conn->real_escape_string($_POST['last_name']);
    $qualification = $conn->real_escape_string($_POST['qualification']);
    $contact_info  = $conn->real_escape_string($_POST['contact_info']);
    $email         = $conn->real_escape_string($_POST['email']);
    $address       = $conn->real_escape_string($_POST['address']);
    $availability  = $conn->real_escape_string($_POST['availability']);
    $joining_date  = $conn->real_escape_string($_POST['joining_date']);
    $status        = $conn->real_escape_string($_POST['status']);

    // Update the doctor's record in the database
    $sql = "UPDATE Doctors SET 
                dept_id='$dept_id',
                first_name='$first_name',
                last_name='$last_name',
                qualification='$qualification',
                contact_info='$contact_info',
                email='$email',
                address='$address',
                availability='$availability',
                joining_date='$joining_date',
                status='$status'
            WHERE doctor_id='$id'";
    if ($conn->query($sql)) {
        $success = "Doctor updated successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }

    // Refresh the doctor's record data
    $query = "SELECT * FROM Doctors WHERE doctor_id='$id'";
    $result = $conn->query($query);
    $doctor = $result->fetch_assoc();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Update Doctor</h2>

    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="dept_id" class="form-label">Department</label>
            <select name="dept_id" id="dept_id" class="form-select" required>
                <option value="" disabled>Select Department</option>
                <?php while($dept = $deptResult->fetch_assoc()) { ?>
                    <option value="<?php echo $dept['dept_id']; ?>" <?php if($dept['dept_id'] == $doctor['dept_id']) echo 'selected'; ?>>
                        <?php echo $dept['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $doctor['first_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $doctor['last_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" name="qualification" id="qualification" class="form-control" value="<?php echo $doctor['qualification']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="contact_info" class="form-label">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" class="form-control" value="<?php echo $doctor['contact_info']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $doctor['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" rows="3" class="form-control"><?php echo $doctor['address']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="availability" class="form-label">Availability</label>
            <input type="text" name="availability" id="availability" class="form-control" value="<?php echo $doctor['availability']; ?>">
        </div>
        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="date" name="joining_date" id="joining_date" class="form-control" value="<?php echo $doctor['joining_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" <?php if($doctor['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if($doctor['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Doctor
        </button>
        <a href="view_doctors.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Doctors List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
