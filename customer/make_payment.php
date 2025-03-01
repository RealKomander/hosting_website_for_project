<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id   = $_SESSION['user_id'];
    $amount        = $conn->real_escape_string($_POST['amount']);
    $payment_method= $conn->real_escape_string($_POST['payment_method']);
    $sql = "INSERT INTO Payments (customer_ID, amount, payment_method, status)
            VALUES ('$customer_id', '$amount', '$payment_method', 'Completed')";
    if ($conn->query($sql) === TRUE) {
        $message = "Payment processed successfully!";
    } else {
        $message = "Error processing payment: " . $conn->error;
    }
}
?>
<html>
<head><title>Make a Payment</title></head>
<body>
<h2>Make a Payment</h2>
<?php if(isset($message)) echo "<p>$message</p>"; ?>
<form method="POST" action="make_payment.php">
    Amount: <input type="text" name="amount" required><br>
    Payment Method: 
    <select name="payment_method">
        <option value="Credit Card">Credit Card</option>
        <option value="PayPal">PayPal</option>
    </select><br>
    <button type="submit">Submit Payment</button>
</form>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
