<?php
// Include common files
include('../includes/header.php');
include('../includes/sidebar.php');
include('../db.php');

// Retrieve patients for the dropdown
$patientQuery = "SELECT patient_id, CONCAT(first_name, ' ', last_name) AS patient_name FROM Patients";
$patientResult = $conn->query($patientQuery);

$error = "";
$success = "";

if (isset($_POST['submit'])) {
    // Sanitize input values
    $patient_id     = $conn->real_escape_string($_POST['patient_id']);
    $bill_date      = $conn->real_escape_string($_POST['bill_date']);
    $amount_due     = $conn->real_escape_string($_POST['amount_due']);
    $discount       = $conn->real_escape_string($_POST['discount']);
    $payment_status = $conn->real_escape_string($_POST['payment_status']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $transaction_id = $conn->real_escape_string($_POST['transaction_id']);
    $notes          = $conn->real_escape_string($_POST['notes']);

    // Insert query
    $sql = "INSERT INTO Billing (patient_id, bill_date, amount_due, discount, payment_status, payment_method, transaction_id, notes)
            VALUES ('$patient_id', '$bill_date', '$amount_due', '$discount', '$payment_status', '$payment_method', '$transaction_id', '$notes')";
    if ($conn->query($sql)) {
        $success = "Billing record added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Add Billing Record</h2>

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
                <option value="" disabled selected>Select Patient</option>
                <?php while ($patient = $patientResult->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($patient['patient_id']); ?>">
                        <?php echo htmlspecialchars($patient['patient_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="bill_date" class="form-label">Bill Date</label>
            <input type="date" name="bill_date" id="bill_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="amount_due" class="form-label">Amount Due</label>
            <input type="number" step="0.01" name="amount_due" id="amount_due" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="0.00">
        </div>
        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-select" required>
                <option value="paid">Paid</option>
                <option value="unpaid" selected>Unpaid</option>
                <option value="partial">Partial</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-select">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="insurance">Insurance</option>
                <option value="online">Online</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaction ID</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Add Billing Record
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
