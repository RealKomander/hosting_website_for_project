<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'billing_operator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$result = $conn->query("SELECT status, SUM(amount) as total_amount FROM Payments GROUP BY status");
?>
<html>
<head><title>Billing Reports</title></head>
<body>
<h2>Billing Reports</h2>
<table border="1">
    <tr>
        <th>Status</th>
        <th>Total Amount</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['total_amount']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
