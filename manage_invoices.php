<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Include database connection
include('db.php');

// Fetch invoices from the database
$query = "SELECT i.invoiceNo, r.registrationNo, i.amount, p.methodName
          FROM Invoice i
          JOIN Registration r ON i.registrationNo = r.registrationNo
          JOIN PaymentMethod p ON i.pMethodNo = p.pMethodNo";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Invoices</title>
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
        <h1>Manage Invoices</h1>
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
        <h2>Invoices List</h2>

        <table>
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Registration No</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['invoiceNo']}</td>
                            <td>{$row['registrationNo']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['methodName']}</td>
                            <td class='actions'>
                                <a href='view_invoice.php?id={$row['invoiceNo']}'>View</a> |
                                <a href='delete_invoice.php?id={$row['invoiceNo']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No invoices found.</td></tr>";
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