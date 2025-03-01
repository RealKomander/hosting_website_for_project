<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$customer_id = $_SESSION['user_id'];
$invoices = $conn->query("SELECT * FROM Payments WHERE customer_ID = '$customer_id'");
?>
<html>
<head><title>Your Invoices & Billing History</title></head>
<body>
<h2>Your Invoices & Billing History</h2>
<table border="1">
    <tr>
        <th>Payment ID</th>
        <th>Amount</th>
        <th>Payment Date</th>
        <th>Method</th>
        <th>Status</th>
    </tr>
    <?php while($invoice = $invoices->fetch_assoc()): ?>
        <tr>
            <td><?php echo $invoice['payment_ID']; ?></td>
            <td><?php echo $invoice['amount']; ?></td>
            <td><?php echo $invoice['payment_date']; ?></td>
            <td><?php echo $invoice['payment_method']; ?></td>
            <td><?php echo $invoice['status']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
