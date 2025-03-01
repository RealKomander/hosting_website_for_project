<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'billing_operator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$sql = "SELECT Payments.*, Users.name FROM Payments 
        JOIN Users ON Payments.customer_ID = Users.user_ID 
        WHERE status = 'Pending'";
$payments = $conn->query($sql);

if(isset($_GET['action']) && isset($_GET['payment_ID'])) {
    $payment_ID = $conn->real_escape_string($_GET['payment_ID']);
    $action     = $_GET['action'];
    if($action == 'complete') {
        $conn->query("UPDATE Payments SET status = 'Completed' WHERE payment_ID = '$payment_ID'");
        $message = "Payment $payment_ID marked as Completed.";
    } elseif($action == 'fail') {
        $conn->query("UPDATE Payments SET status = 'Failed' WHERE payment_ID = '$payment_ID'");
        $message = "Payment $payment_ID marked as Failed.";
    }
    header("Location: process_payment.php");
    exit();
}
?>
<html>
<head><title>Process Customer Payments</title></head>
<body>
<h2>Process Customer Payments</h2>
<?php if(isset($message)) echo "<p>$message</p>"; ?>
<table border="1">
    <tr>
        <th>Payment ID</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($payment = $payments->fetch_assoc()): ?>
        <tr>
            <td><?php echo $payment['payment_ID']; ?></td>
            <td><?php echo $payment['name']; ?></td>
            <td><?php echo $payment['amount']; ?></td>
            <td><?php echo $payment['payment_method']; ?></td>
            <td><?php echo $payment['status']; ?></td>
            <td>
                <a href="process_payment.php?action=complete&payment_ID=<?php echo $payment['payment_ID']; ?>">Complete</a> |
                <a href="process_payment.php?action=fail&payment_ID=<?php echo $payment['payment_ID']; ?>">Fail</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
