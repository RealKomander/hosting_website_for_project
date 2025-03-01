<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'administrator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$sql = "SELECT VMs.*, Users.name AS customer_name, HostingPlans.plan_name 
        FROM VMs 
        JOIN Users ON VMs.customer_id = Users.user_ID 
        JOIN HostingPlans ON VMs.plan_ID = HostingPlans.plan_ID";
$vms = $conn->query($sql);
?>
<html>
<head><title>Provision & Configure VMs</title></head>
<body>
<h2>Provision & Configure VMs</h2>
<table border="1">
    <tr>
        <th>VM ID</th>
        <th>Customer</th>
        <th>Plan</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($vm = $vms->fetch_assoc()): ?>
        <tr>
            <td><?php echo $vm['VM_ID']; ?></td>
            <td><?php echo $vm['customer_name']; ?></td>
            <td><?php echo $vm['plan_name']; ?></td>
            <td><?php echo $vm['status']; ?></td>
            <td>
                <a href="provision_vm.php?action=configure&vm_id=<?php echo $vm['VM_ID']; ?>">Configure</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<?php
if(isset($_GET['action']) && $_GET['action'] == 'configure' && isset($_GET['vm_id'])) {
    $vm_id = $conn->real_escape_string($_GET['vm_id']);
    echo "<p>VM $vm_id has been provisioned and configured.</p>";
}
?>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
