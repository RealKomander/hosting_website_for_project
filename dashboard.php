<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_type = $_SESSION['user_type'];
?>
<html>
<head><title>Dashboard</title></head>
<body>
<h2>Dashboard</h2>
<p>Welcome, User ID <?php echo $_SESSION['user_id']; ?>!</p>

<?php
if ($user_type == 'customer') {
    echo '<ul>
            <li><a href="customer/order_vm.php">Order a New VM</a></li>
            <li><a href="customer/manage_vms.php">Manage Your VMs</a></li>
            <li><a href="customer/invoices.php">View Invoices & Billing History</a></li>
            <li><a href="customer/make_payment.php">Make a Payment</a></li>
          </ul>';
} elseif ($user_type == 'administrator') {
    echo '<ul>
            <li><a href="admin/provision_vm.php">Provision & Configure VMs</a></li>
            <li><a href="admin/assign_vm.php">Assign VMs to Server Nodes</a></li>
            <li><a href="admin/monitor_system.php">Monitor System Performance</a></li>
            <li><a href="admin/manage_vms.php">Suspend/Delete VMs</a></li>
          </ul>';
} elseif ($user_type == 'billing_operator') {
    echo '<ul>
            <li><a href="billing/process_payment.php">Process Payments</a></li>
            <li><a href="billing/issue_invoice.php">Issue Invoices</a></li>
            <li><a href="billing/billing_reports.php">Generate Billing Reports</a></li>
            <li><a href="billing/handle_refund.php">Handle Refunds/Disputes</a></li>
          </ul>';
}
?>
<a href="logout.php">Logout</a>
</body>
</html>
