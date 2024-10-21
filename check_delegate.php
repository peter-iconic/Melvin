<?php
session_start();
include('db.php'); // Database connection

// Ensure the user is logged in and is a delegate
if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

// Check if courseNo is set in the POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['courseNo'])) {
        die("Error: courseNo is not set in the POST request.");
    }

    // Get delegateNo from the session
    $delegateNo = $_SESSION['userID']; // Assuming delegateNo is same as userID in this case
    $courseNo = $_POST['courseNo'];
    $employeeNo = 1; // Example employee handling registration. Adjust as needed.

    // Check if the delegate exists in the delegate table
    $checkDelegateQuery = "SELECT * FROM delegate WHERE delegateNo = ?";
    $stmt = $conn->prepare($checkDelegateQuery);
    $stmt->bind_param('i', $delegateNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delegate exists, proceed with registration
        // Check if the course exists
        $courseCheckQuery = "SELECT * FROM Course WHERE courseNo = ?";
        $stmt = $conn->prepare($courseCheckQuery);
        $stmt->bind_param('i', $courseNo);
        $stmt->execute();
        $courseResult = $stmt->get_result();

        if ($courseResult->num_rows > 0) {
            // Course exists, now register the delegate for the course
            $registrationQuery = "INSERT INTO Registration (courseNo, delegateNo, employeeNo) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($registrationQuery);
            $stmt->bind_param('iii', $courseNo, $delegateNo, $employeeNo);

            if ($stmt->execute()) {
                echo "Registered successfully!";
            } else {
                echo "Error registering: " . $stmt->error;
            }
        } else {
            echo "Error: Course not found.";
        }
    } else {
        echo "Error: Delegate does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Delegate</title>
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