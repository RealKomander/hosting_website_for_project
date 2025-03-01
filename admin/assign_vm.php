<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'administrator') {
    header("Location: ../login.php");
    exit();
}
require '../db.php';

$vms     = $conn->query("SELECT * FROM VMs");
$servers = $conn->query("SELECT * FROM ServerNodes");

if(isset($_POST['assign'])) {
    $vm_id     = $conn->real_escape_string($_POST['vm_id']);
    $server_id = $conn->real_escape_string($_POST['server_id']);
    $sql = "UPDATE VMs SET server_ID = '$server_id' WHERE VM_ID = '$vm_id'";
    if($conn->query($sql) === TRUE) {
        $message = "VM assigned to server successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>
<html>
<head><title>Assign VMs to Server Nodes</title></head>
<body>
<h2>Assign VMs to Server Nodes</h2>
<?php if(isset($message)) echo "<p>$message</p>"; ?>
<form method="POST" action="assign_vm.php">
    <label for="vm_id">Select VM:</label>
    <select name="vm_id" id="vm_id">
        <?php while($vm = $vms->fetch_assoc()): ?>
            <option value="<?php echo $vm['VM_ID']; ?>">VM <?php echo $vm['VM_ID']; ?> (Status: <?php echo $vm['status']; ?>)</option>
        <?php endwhile; ?>
    </select><br><br>
    
    <label for="server_id">Select Server Node:</label>
    <select name="server_id" id="server_id">
        <?php while($server = $servers->fetch_assoc()): ?>
            <option value="<?php echo $server['server_ID']; ?>"><?php echo $server['hostname']; ?> (IP: <?php echo $server['IP_address']; ?>)</option>
        <?php endwhile; ?>
    </select><br><br>
    <button type="submit" name="assign">Assign VM</button>
</form>
<a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
