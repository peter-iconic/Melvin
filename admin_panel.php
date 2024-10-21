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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #5cb85c;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
        }

        a:hover {
            background-color: #4cae4c;
        }

        ul li a {
            display: inline-block;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

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