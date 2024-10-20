<?php
session_start();
include('db.php'); // Database connection

if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

$clientID = $_SESSION['userID']; // Assume this is the client ID

// Fetch invoices for the logged-in client
$query = "
    SELECT Invoice.invoiceNo, Invoice.amount, Invoice.dueDate, Course.title 
    FROM Invoice 
    JOIN Registration ON Invoice.registrationNo = Registration.registrationNo 
    JOIN Course ON Registration.courseNo = Course.courseNo 
    WHERE Registration.clientID = '$clientID'";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error: ' . mysqli_error($conn)); // Show the exact query error
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Invoices</title>
</head>

<body>
    <h1>Your Invoices</h1>
    <table border="1">
        <tr>
            <th>Invoice No</th>
            <th>Course Title</th>
            <th>Amount</th>
            <th>Due Date</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['invoiceNo']; ?></td>
                <td><?php echo $row['title']; ?></td> <!-- Course title displayed here -->
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['dueDate']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>