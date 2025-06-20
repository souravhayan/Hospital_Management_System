<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Initialize the search query
$searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Query to retrieve billing data with patient details, filtered by search input
$query = "SELECT b.*, CONCAT(p.first_name, ' ', p.last_name) AS patient_name 
          FROM Billing b
          LEFT JOIN Patients p ON b.patient_id = p.patient_id
          WHERE b.bill_id LIKE '%$searchQuery%' 
             OR p.first_name LIKE '%$searchQuery%' 
             OR p.last_name LIKE '%$searchQuery%' 
             OR b.bill_date LIKE '%$searchQuery%' 
             OR b.payment_status LIKE '%$searchQuery%' 
             OR b.payment_method LIKE '%$searchQuery%'
             OR b.transaction_id LIKE '%$searchQuery%'
          ORDER BY b.bill_date DESC";
$result = $conn->query($query);
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Billing Records</h2>
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Bill ID, Patient Info, Transaction ID, Payment Status, etc." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i>Search
            </button>
        </div>
    </form>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus me-1"></i>Add New Billing Record
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Patient</th>
                <th>Bill Date</th>
                <th>Amount Due</th>
                <th>Discount</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Transaction ID</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($bill = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($bill['bill_id']); ?></td>
                    <td><?php echo htmlspecialchars($bill['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($bill['bill_date']); ?></td>
                    <td><?php echo htmlspecialchars($bill['amount_due']); ?></td>
                    <td><?php echo htmlspecialchars($bill['discount']); ?></td>
                    <td><?php echo htmlspecialchars($bill['total_amount']); ?></td>
                    <td><?php echo htmlspecialchars($bill['payment_status']); ?></td>
                    <td><?php echo htmlspecialchars($bill['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($bill['transaction_id']); ?></td>
                    <td><?php echo htmlspecialchars($bill['notes']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo htmlspecialchars($bill['bill_id']); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="delete.php?id=<?php echo htmlspecialchars($bill['bill_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this billing record?')">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center">No billing records found.</td>
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
