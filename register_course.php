<?php
session_start();
include('db.php'); // Database connection

if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseNo = $_POST['courseNo'];
    $delegateNo = $_SESSION['userID']; // Assuming delegateNo is same as userID in this case
    $employeeNo = 1; // Example employee handling registration. Adjust as needed.

    // Ensure the courseNo exists in the Course table
    $courseCheckQuery = "SELECT * FROM Course WHERE courseNo = ?";
    if ($stmt = mysqli_prepare($conn, $courseCheckQuery)) {
        mysqli_stmt_bind_param($stmt, 'i', $courseNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // If course exists, proceed with registration
            $query = "INSERT INTO Registration (courseNo, delegateNo, employeeNo) 
                      VALUES ('$courseNo', '$delegateNo', '$employeeNo')";
            if (mysqli_query($conn, $query)) {
                echo "Registered successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Course not found.";
        }
    } else {
        echo "Error: Could not check course.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for a Course</title>
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

        form {
            max-width: 500px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            color: #333;
        }

        select,
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Available Courses</h1>
    <form method="post" action="">
        <label for="courseNo">Select Course:</label>
        <select name="courseNo" id="courseNo" required>
            <option value="">-- Select a Course --</option>
            <?php
            // Fetch courses from the database
            $coursesQuery = "SELECT courseNo, title FROM Course";
            $coursesResult = mysqli_query($conn, $coursesQuery);
            if ($coursesResult) {
                while ($row = mysqli_fetch_assoc($coursesResult)) {
                    echo "<option value='{$row['courseNo']}'>{$row['title']}</option>";
                }
            } else {
                echo "<option value=''>No courses available</option>";
            }
            ?>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>