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
    <h1>Client Dashboard</h1>
    <ul>
        <li><a href="view_courses.php">View Courses</a></li>
        <li><a href="register_course.php">Register for a Course</a></li>
        <li><a href="view_invoices.php">View Invoices</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>

</html>