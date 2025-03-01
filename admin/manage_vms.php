<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'administrator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$sql = "SELECT VMs.*, Users.name AS customer_name 
        FROM VMs 
        JOIN Users ON VMs.customer_id = Users.user_ID";
$vms = $conn->query($sql);

if(isset($_GET['action']) && isset($_GET['vm_id'])) {
    $vm_id  = $conn->real_escape_string($_GET['vm_id']);
    $action = $_GET['action'];
    if($action == 'suspend') {
        $conn->query("UPDATE VMs SET status = 'Suspended' WHERE VM_ID = '$vm_id'");
        $message = "VM $vm_id suspended.";
    } elseif($action == 'delete') {
        $conn->query("DELETE FROM VMs WHERE VM_ID = '$vm_id'");
        $message = "VM $vm_id deleted.";
    }
    header("Location: manage_vms.php");
    exit();
}
?>
<html>
<head><title>Suspend/Delete VMs</title></head>
<body>
<h2>Suspend or Delete VMs</h2>
<?php if(isset($message)) echo "<p>$message</p>"; ?>
<table border="1">
    <tr>
        <th>VM ID</th>
        <th>Customer</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($vm = $vms->fetch_assoc()): ?>
        <tr>
            <td><?php echo $vm['VM_ID']; ?></td>
            <td><?php echo $vm['customer_name']; ?></td>
            <td><?php echo $vm['status']; ?></td>
            <td>
                <a href="manage_vms.php?action=suspend&vm_id=<?php echo $vm['VM_ID']; ?>">Suspend</a> |
                <a href="manage_vms.php?action=delete&vm_id=<?php echo $vm['VM_ID']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
