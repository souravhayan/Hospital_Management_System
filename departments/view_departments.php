<?php
// Include the common header and sidebar
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Initialize the search query
$searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Query to retrieve departments filtered by search criteria
$query = "SELECT * FROM Departments 
          WHERE dept_id LIKE '%$searchQuery%' 
             OR name LIKE '%$searchQuery%' 
             OR status LIKE '%$searchQuery%' 
          ORDER BY dept_id ASC";
$result = $conn->query($query);
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Departments List</h2>
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by ID, Department Name, or Status" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus me-1"></i>Add New Department
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['dept_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo htmlspecialchars($row['dept_id']); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="delete.php?id=<?php echo htmlspecialchars($row['dept_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this department?')">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No departments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="../index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
