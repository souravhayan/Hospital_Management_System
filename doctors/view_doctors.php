<?php
// Include the common header and sidebar
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Initialize the search query
$searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Fetch doctor records based on the search query
$query = "SELECT d.*, dp.name AS department_name 
          FROM Doctors d 
          LEFT JOIN Departments dp ON d.dept_id = dp.dept_id
          WHERE d.doctor_id LIKE '%$searchQuery%' 
             OR d.first_name LIKE '%$searchQuery%' 
             OR d.last_name LIKE '%$searchQuery%' 
             OR dp.name LIKE '%$searchQuery%'  
 
          ORDER BY d.doctor_id DESC";
$result = $conn->query($query);
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Doctors List</h2>
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Doctor ID, Name, or Department" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus me-1"></i>Add New Doctor
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>First Name</th>
                <th>Last Name</th>
               
                <th>Qualification</th>
                <th>Contact Info</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['doctor_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    
                    <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_info']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo htmlspecialchars($row['doctor_id']); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="delete.php?id=<?php echo htmlspecialchars($row['doctor_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this doctor?')">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center">No doctors found.</td>
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
