<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = $conn->real_escape_string($_POST['name']);
    $email        = $conn->real_escape_string($_POST['email']);
    $phone        = $conn->real_escape_string($_POST['phone']);
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type    = 'customer';

    $sql = "INSERT INTO Users (name, email, phone_number, password_hash, user_type)
            VALUES ('$name', '$email', '$phone', '$password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_id']   = $conn->insert_id;
        $_SESSION['user_type'] = $user_type;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST" action="register.php">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Phone: <input type="text" name="phone" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account? Login here</a>
</body>
</html>
