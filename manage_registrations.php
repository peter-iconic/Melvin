<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Include database connection
include('db.php');

// Fetch registrations from the database
$query = "SELECT r.registrationNo, c.title AS courseTitle, d.firstName AS delegateFirstName, d.lastName AS delegateLastName, e.firstName AS employeeFirstName, e.lastName AS employeeLastName
          FROM Registration r
          JOIN Course c ON r.courseNo = c.courseNo
          JOIN Delegate d ON r.delegateNo = d.delegateNo
          JOIN Employee e ON r.employeeNo = e.employeeNo";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Registrations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
            background-color: #333;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .actions a {
            text-decoration: none;
            color: #5cb85c;
            margin: 0 5px;
        }

        .actions a:hover {
            text-decoration: underline;
            color: #4cae4c;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Manage Registrations</h1>
    </header>

    <nav>
        <ul>
            <li><a href="manage_courses.php">Manage Courses</a></li>
            <li><a href="manage_registrations.php">Manage Registrations</a></li>
            <li><a href="manage_invoices.php">Manage Invoices</a></li>
            <li><a href="register.php">Create Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Registrations List</h2>

        <table>
            <thead>
                <tr>
                    <th>Registration No</th>
                    <th>Course Title</th>
                    <th>Delegate Name</th>
                    <th>Employee Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['registrationNo']}</td>
                            <td>{$row['courseTitle']}</td>
                            <td>{$row['delegateFirstName']} {$row['delegateLastName']}</td>
                            <td>{$row['employeeFirstName']} {$row['employeeLastName']}</td>
                            <td class='actions'>
                                <a href='edit_registration.php?id={$row['registrationNo']}'>Edit</a> |
                                <a href='delete_registration.php?id={$row['registrationNo']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No registrations found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
    </footer>
</body>

</html>