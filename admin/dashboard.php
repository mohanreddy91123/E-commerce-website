<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>

<h1>Admin Dashboard</h1>

<p>You are logged in as Admin</p>

<a href="logout.php">Logout</a>

</body>
</html>
