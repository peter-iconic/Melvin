<?php
session_start();
include('db.php'); // Database connection

if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

$clientID = $_SESSION['userID']; // Assume this is the client ID

// Fetch invoices for the logged-in client, using delegateNo instead of clientID
$query = "
    SELECT invoice.invoiceNo, invoice.amount, invoice.dueDate, course.title 
    FROM Invoice 
    JOIN Registration ON invoice.registrationNo = Registration.registrationNo 
    JOIN Course ON Registration.courseNo = Course.courseNo 
    WHERE Registration.delegateNo = ?"; // Use delegateNo as the client identifier

if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $clientID); // Bind clientID as an integer (from delegateNo)
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die('Error: ' . mysqli_error($conn)); // Show the exact query error
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Invoices</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            text-align: center;
        }

        table td {
            font-size: 14px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .back-link {
            display: inline-block;
            margin: 20px auto;
            text-align: center;
        }

        .back-link a {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-link a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Invoices</h1>
        <table>
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Course Title</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['invoiceNo']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td> <!-- Course title displayed here -->
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['dueDate']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="back-link">
            <a href="client_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>