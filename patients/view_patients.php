<?php
// Include the common header and sidebar
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Initialize the search query
$searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Fetch patient records based on the search query
$query = "SELECT * FROM Patients 
          WHERE patient_id LIKE '%$searchQuery%' 
             OR first_name LIKE '%$searchQuery%' 
             OR last_name LIKE '%$searchQuery%' 
     
             OR gender LIKE '%$searchQuery%' 
             OR blood_group LIKE '%$searchQuery%'  
         
          ORDER BY patient_id DESC";
$result = $conn->query($query);
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Patients List</h2>
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Patient ID, Name, Gender, or Blood Group" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus me-1"></i>Add New Patient
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Contact Info</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patient_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['dob']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_info']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo htmlspecialchars($row['patient_id']); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="delete.php?id=<?php echo htmlspecialchars($row['patient_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this patient?')">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">No patients found.</td>
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
