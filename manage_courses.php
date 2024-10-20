<?php
include('db.php');
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch locations from the database for the dropdown
$locationsQuery = "SELECT locationNo, address FROM Location";
$locationsResult = mysqli_query($conn, $locationsQuery);
$locations = [];
if ($locationsResult) {
    while ($row = mysqli_fetch_assoc($locationsResult)) {
        $locations[] = $row;
    }
}

// Fetch employees from the database for the dropdown
$employeesQuery = "SELECT employeeNo, firstName, lastName FROM Employee";
$employeesResult = mysqli_query($conn, $employeesQuery);
$employees = [];
if ($employeesResult) {
    while ($row = mysqli_fetch_assoc($employeesResult)) {
        $employees[] = $row;
    }
}



// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $locationNo = (int) $_POST['locationNo']; // Cast to int for safety
    $courseTypeNo = (int) $_POST['courseTypeNo'];
    $courseFeeNo = (int) $_POST['courseFeeNo'];
    $employeeNo = (int) $_POST['employeeNo'];

    // Check if the employee exists in the Employee table
    $employeeCheckQuery = "SELECT * FROM Employee WHERE employeeNo = ?";
    $stmtCheck = $conn->prepare($employeeCheckQuery);
    $stmtCheck->bind_param("i", $employeeNo);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows == 0) {
        // Employee does not exist
        echo "<p style='color: red;'>Error: Employee number does not exist.</p>";
    } else {
        // Prepare and execute the SQL query using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Course (title, description, locationNo, courseTypeNo, courseFeeNo, employeeNo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiii", $title, $description, $locationNo, $courseTypeNo, $courseFeeNo, $employeeNo);

        if ($stmt->execute()) {
            // Redirect to the manage courses page on success
            echo "<p style='color: green;'>Course added successfully!</p>";
            header('refresh:2; url=admin_panel.php'); // Redirect after 2 seconds
            exit();
        } else {
            // Error handling for any failed query execution
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        p {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Add New Course</h1>
    <!-- Form for adding a new course -->
    <form method="post" action="">
        <!-- Input for course title -->
        <input type="text" name="title" placeholder="Course Title" required>

        <!-- Textarea for course description -->
        <textarea name="description" placeholder="Course Description" required></textarea>

        <!-- Dropdown for selecting location -->
        <select name="locationNo" required>
            <option value="">Select Location</option>
            <?php foreach ($locations as $location) { ?>
                <option value="<?php echo $location['locationNo']; ?>"><?php echo $location['address']; ?></option>
            <?php } ?>
        </select>

        <!-- Dropdown for selecting course type -->
        <select name="courseTypeNo" required>
            <option value="">Select Course Type</option>
            <?php foreach ($courseTypes as $courseType) { ?>
                <option value="<?php echo $courseType['courseTypeNo']; ?>"><?php echo $courseType['courseTypeName']; ?>
                </option>
            <?php } ?>
        </select>

        <!-- Input for course fee number -->
        <input type="number" name="courseFeeNo" placeholder="Course Fee No" required>

        <!-- Dropdown for selecting employee number -->
        <select name="employeeNo" required>
            <option value="">Select Employee</option>
            <?php foreach ($employees as $employee) { ?>
                <option value="<?php echo $employee['employeeNo']; ?>">
                    <?php echo $employee['firstName'] . ' ' . $employee['lastName']; ?>
                </option>
            <?php } ?>
        </select>

        <!-- Submit button to add the course -->
        <button type="submit">Add Course</button>
    </form>
</body>

</html>