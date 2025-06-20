<?php
// Include common header and sidebar files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Get list of active departments (for the dropdown)
$deptQuery = "SELECT dept_id, name FROM Departments WHERE status='active'";
$deptResult = $conn->query($deptQuery);

$error = "";
$success = "";

if (isset($_POST['submit'])) {
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

    // Insert query for adding a new doctor
    $sql = "INSERT INTO Doctors (dept_id, first_name, last_name, qualification, contact_info, email, address, availability, joining_date, status) 
            VALUES ('$dept_id', '$first_name', '$last_name', '$specialty', '$qualification', '$contact_info', '$email', '$address', '$availability', '$joining_date', '$status')";
    
    if($conn->query($sql)) {
        $success = "Doctor added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Add New Doctor</h2>

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
            <label for="dept_id" class="form-label">Department</label>
            <select name="dept_id" id="dept_id" class="form-select" required>
                <option value="" disabled selected>Select Department</option>
                <?php while($dept = $deptResult->fetch_assoc()) { ?>
                    <option value="<?php echo $dept['dept_id']; ?>">
                        <?php echo $dept['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" name="qualification" id="qualification" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contact_info" class="form-label">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" rows="3" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="availability" class="form-label">Availability</label>
            <input type="text" name="availability" id="availability" class="form-control">
        </div>
        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="date" name="joining_date" id="joining_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="" disabled selected>Select Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Add Doctor
        </button>
        <a href="view_doctors.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Doctors List
        </a>
    </form>
</div>

<?php
include('../includes/footer.php');
?>
