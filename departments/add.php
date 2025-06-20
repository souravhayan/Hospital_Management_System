<?php
// Include the common header and sidebar
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

$error = "";
$success = "";
if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "INSERT INTO Departments (name, description, status)
            VALUES ('$name', '$description', '$status')";
    if ($conn->query($sql)) {
        $success = "Department added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Add New Department</h2>

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
            <label for="name" class="form-label">Department Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
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
            <i class="fas fa-save me-1"></i> Add Department
        </button>
        <a href="view_departments.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Departments List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
