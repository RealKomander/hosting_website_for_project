<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$customer_id = $_SESSION['user_id'];
$vms = $conn->query("SELECT * FROM VMs WHERE customer_id = '$customer_id'");

if(isset($_GET['action']) && isset($_GET['vm_id'])) {
    $vm_id  = $conn->real_escape_string($_GET['vm_id']);
    $action = $_GET['action'];
    if($action == 'start') {
        $new_status = 'Running';
    } elseif($action == 'stop') {
        $new_status = 'Stopped';
    } elseif($action == 'restart') {
        $new_status = 'Running';
    }
    $conn->query("UPDATE VMs SET status = '$new_status' WHERE VM_ID = '$vm_id' AND customer_id = '$customer_id'");
    header("Location: manage_vms.php");
    exit();
}
?>
<html>
<head><title>Manage Your VMs</title></head>
<body>
<h2>Your VMs</h2>
<table border="1">
    <tr>
        <th>VM ID</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($vm = $vms->fetch_assoc()): ?>
        <tr>
            <td><?php echo $vm['VM_ID']; ?></td>
            <td><?php echo $vm['status']; ?></td>
            <td>
                <a href="manage_vms.php?action=start&vm_id=<?php echo $vm['VM_ID']; ?>">Start</a> |
                <a href="manage_vms.php?action=stop&vm_id=<?php echo $vm['VM_ID']; ?>">Stop</a> |
                <a href="manage_vms.php?action=restart&vm_id=<?php echo $vm['VM_ID']; ?>">Restart</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
