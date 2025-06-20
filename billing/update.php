<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Check if billing ID is provided
if (!isset($_GET['id'])) {
    header("Location: view_bills.php");
    exit;
}
$id = $_GET['id'];

// Retrieve current billing data
$query = "SELECT * FROM Billing WHERE bill_id='$id'";
$result = $conn->query($query);
if ($result->num_rows != 1) {
    die("Billing record not found.");
}
$bill = $result->fetch_assoc();

// Retrieve patients for dropdown
$patientQuery = "SELECT patient_id, CONCAT(first_name, ' ', last_name) AS patient_name FROM Patients";
$patientResult = $conn->query($patientQuery);

$error = "";
$success = "";

if (isset($_POST['update'])) {
    // Sanitize input values
    $patient_id     = $conn->real_escape_string($_POST['patient_id']);
    $bill_date      = $conn->real_escape_string($_POST['bill_date']);
    $amount_due     = $conn->real_escape_string($_POST['amount_due']);
    $discount       = $conn->real_escape_string($_POST['discount']);
    $payment_status = $conn->real_escape_string($_POST['payment_status']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $transaction_id = $conn->real_escape_string($_POST['transaction_id']);
    $notes          = $conn->real_escape_string($_POST['notes']);

    // Update query
    $sql = "UPDATE Billing SET 
              patient_id='$patient_id',
              bill_date='$bill_date',
              amount_due='$amount_due',
              discount='$discount',
              payment_status='$payment_status',
              payment_method='$payment_method',
              transaction_id='$transaction_id',
              notes='$notes'
            WHERE bill_id='$id'";
    if ($conn->query($sql)) {
        $success = "Billing record updated successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }

    // Refresh billing data
    $query = "SELECT * FROM Billing WHERE bill_id='$id'";
    $result = $conn->query($query);
    $bill = $result->fetch_assoc();
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Update Billing Record</h2>

    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                <option value="" disabled>Select Patient</option>
                <?php while ($patient = $patientResult->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($patient['patient_id']); ?>" <?php if ($patient['patient_id'] == $bill['patient_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($patient['patient_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="bill_date" class="form-label">Bill Date</label>
            <input type="date" name="bill_date" id="bill_date" class="form-control" value="<?php echo htmlspecialchars($bill['bill_date']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="amount_due" class="form-label">Amount Due</label>
            <input type="number" step="0.01" name="amount_due" id="amount_due" class="form-control" value="<?php echo htmlspecialchars($bill['amount_due']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="<?php echo htmlspecialchars($bill['discount']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-select" required>
                <option value="paid" <?php if ($bill['payment_status'] == 'paid') echo 'selected'; ?>>Paid</option>
                <option value="unpaid" <?php if ($bill['payment_status'] == 'unpaid') echo 'selected'; ?>>Unpaid</option>
                <option value="partial" <?php if ($bill['payment_status'] == 'partial') echo 'selected'; ?>>Partial</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-select">
                <option value="cash" <?php if ($bill['payment_method'] == 'cash') echo 'selected'; ?>>Cash</option>
                <option value="card" <?php if ($bill['payment_method'] == 'card') echo 'selected'; ?>>Card</option>
                <option value="insurance" <?php if ($bill['payment_method'] == 'insurance') echo 'selected'; ?>>Insurance</option>
                <option value="online" <?php if ($bill['payment_method'] == 'online') echo 'selected'; ?>>Online</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaction ID</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control" value="<?php echo htmlspecialchars($bill['transaction_id']); ?>">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="2"><?php echo htmlspecialchars($bill['notes']); ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Billing Record
        </button>
        <a href="view_bills.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Bills List
        </a>
    </form>
</div>

<?php
// Include the common footer
include('../includes/footer.php');
?>
