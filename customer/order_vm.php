<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$plans = $conn->query("SELECT * FROM HostingPlans");
?>
<html>
<head><title>Order a New VM</title></head>
<body>
<h2>Order a New VM</h2>
<form method="POST" action="order_vm.php">
    <label for="plan_id">Select Hosting Plan:</label>
    <select name="plan_id" id="plan_id">
        <?php while($plan = $plans->fetch_assoc()): ?>
            <option value="<?php echo $plan['plan_ID']; ?>">
                <?php echo $plan['plan_name']; ?> - $<?php echo $plan['price']; ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>
    <button type="submit" name="order_vm">Order VM</button>
</form>
<?php
if (isset($_POST['order_vm'])) {
    $plan_id     = $conn->real_escape_string($_POST['plan_id']);
    $customer_id = $_SESSION['user_id'];
    $server_result = $conn->query("SELECT server_ID FROM ServerNodes ORDER BY RAND() LIMIT 1");
    $server        = $server_result->fetch_assoc();
    $server_id   = $server['server_ID'];
    $ordered_until = date('Y-m-d H:i:s', strtotime('+30 days'));
    $sql = "INSERT INTO VMs (customer_id, plan_ID, server_ID, status, ordered_until)
            VALUES ('$customer_id', '$plan_id', '$server_id', 'Running', '$ordered_until')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>VM ordered successfully!</p>";
    } else {
        echo "<p>Error ordering VM: " . $conn->error . "</p>";
    }
}
?>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
