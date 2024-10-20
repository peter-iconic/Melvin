<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>
<link rel="stylesheet" href="client.css">

<body>
    <h1>Admin Dashboard</h1>
    <ul>
        <li><a href="manage_courses.php">Manage Courses</a></li>
        <li><a href="manage_registrations.php">Manage Registrations</a></li>
        <li><a href="manage_invoices.php">Manage Invoices</a></li>
        <li><a href="register.php">Create Users</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>

</html>