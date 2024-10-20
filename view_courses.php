<?php
session_start();
include('db.php'); // Database connection

if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

// Query to get courses along with course type and fee
$query = "
    SELECT c.courseNo, c.title, ct.description AS courseType, cf.amount AS fee
    FROM Course c
    JOIN CourseType ct ON c.courseTypeNo = ct.courseTypeNo
    JOIN CourseFee cf ON c.courseFeeNo = cf.courseFeeNo
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Courses</title>
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
    </style>
</head>

<body>
    <h1>Available Courses</h1>
    <table>
        <thead>
            <tr>
                <th>Course No</th>
                <th>Course Name</th>
                <th>Course Type</th>
                <th>Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['courseNo']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['courseType']; ?></td>
                    <td><?php echo number_format($row['fee'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>