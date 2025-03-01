<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'billing_operator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

if(isset($_GET['payment_ID'])) {
    $payment_ID = $conn->real_escape_string($_GET['payment_ID']);
    $conn->query("UPDATE Payments SET status = 'Failed' WHERE payment_ID = '$payment_ID'");
    $message = "Payment $payment_ID has been refunded/marked as Failed.";
}
?>
<html>
<head><title>Handle Refunds / Payment Disputes</title></head>
<body>
<h2>Handle Refunds / Payment Disputes</h2>
<?php if(isset($message)) echo "<p>$message</p>"; ?>
<form method="GET" action="handle_refund.php">
    Payment ID: <input type="text" name="payment_ID" required><br>
    <button type="submit">Process Refund/Dispute</button>
</form>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
