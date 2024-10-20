<?php
session_start();
include('db.php'); // Database connection

if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM Course";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Courses</title>
</head>

<body>
    <h1>Available Courses</h1>
    <table border="1">
        <tr>
            <th>Course No</th>
            <th>Course Name</th>
            <th>Course Type</th>
            <th>Fee</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['courseNo']; ?></td>
                <td><?php echo $row['courseName']; ?></td>
                <td><?php echo $row['courseType']; ?></td>
                <td><?php echo $row['fee']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>