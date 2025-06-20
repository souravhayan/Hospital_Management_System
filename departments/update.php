<?php
// Include the common header, sidebar, and database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Check if the department ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: view_departments.php");
    exit;
}
$id = $_GET['id'];

// Retrieve the existing department record
$query = "SELECT * FROM Departments WHERE dept_id='$id'";
$result = $conn->query($query);
if ($result->num_rows != 1) {
    die("Department not found.");
}
$department = $result->fetch_assoc();

$error = "";
$success = "";

if (isset($_POST['update'])) {
    // Sanitize input values
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update the department in the database
    $sql = "UPDATE Departments SET 
                name='$name',
                description='$description',
                status='$status'
            WHERE dept_id='$id'";
    if ($conn->query($sql)) {
        $success = "Department updated successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }

    // Refresh the department record data
    $query = "SELECT * FROM Departments WHERE dept_id='$id'";
    $result = $conn->query($query);
    $department = $result->fetch_assoc();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Update Department</h2>

    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo $department['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required><?php echo $department['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" <?php if ($department['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($department['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Department
        </button>
        <a href="view_departments.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Departments List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
