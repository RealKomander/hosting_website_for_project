<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'administrator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$result = $conn->query("SELECT status, COUNT(*) as count FROM VMs GROUP BY status");
$vm_stats = [];
while($row = $result->fetch_assoc()){
    $vm_stats[$row['status']] = $row['count'];
}
?>
<html>
<head><title>Monitor System Performance</title></head>
<body>
<h2>System Performance & Resource Allocation</h2>
<h3>VM Status Overview</h3>
<ul>
    <li>Running: <?php echo isset($vm_stats['Running']) ? $vm_stats['Running'] : 0; ?></li>
    <li>Stopped: <?php echo isset($vm_stats['Stopped']) ? $vm_stats['Stopped'] : 0; ?></li>
    <li>Suspended: <?php echo isset($vm_stats['Suspended']) ? $vm_stats['Suspended'] : 0; ?></li>
</ul>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
