<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'billing_operator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $conn->real_escape_string($_POST['customer_id']);
    $amount      = $conn->real_escape_string($_POST['amount']);
    $payment_method = 'Credit Card';
    $sql = "INSERT INTO Payments (customer_ID, amount, payment_method, status)
            VALUES ('$customer_id', '$amount', '$payment_method', 'Pending')";
    if ($conn->query($sql) === TRUE) {
        $message = "Invoice issued successfully.";
    } else {
        $message = "Error issuing invoice: " . $conn->error;
    }
}
?>
<html>
<head><title>Issue Invoice</title></head>
<body>
<h2>Issue Invoice</h2>
<?php if(isset($message)) echo "<p>$message</p>"; ?>
<form method="POST" action="issue_invoice.php">
    Customer ID: <input type="text" name="customer_id" required><br>
    Amount: <input type="text" name="amount" required><br>
    <button type="submit">Issue Invoice</button>
</form>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
