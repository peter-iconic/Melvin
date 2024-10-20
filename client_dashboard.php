<?php
session_start();
if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Client Dashboard</title>
</head>
<link rel="stylesheet" href="client.css">

<body>
    <h1>Client Dashboard</h1>
    <ul>
        <li><a href="view_courses.php">View Courses</a></li>
        <li><a href="register_course.php">Register for a Course</a></li>
        <li><a href="view_invoices.php">View Invoices</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>

</html>