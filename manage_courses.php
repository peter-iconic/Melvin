<?php
include('db.php');
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch locations from the database for the dropdown
$locationsQuery = "SELECT locationNo, address FROM Location"; // Use 'address' instead of 'name'
$locationsResult = mysqli_query($conn, $locationsQuery);
$locations = [];
if ($locationsResult) {
    while ($row = mysqli_fetch_assoc($locationsResult)) {
        $locations[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $locationNo = (int) $_POST['locationNo']; // Cast to int for safety
    $courseTypeNo = (int) $_POST['courseTypeNo'];
    $courseFeeNo = (int) $_POST['courseFeeNo'];
    $employeeNo = (int) $_POST['employeeNo'];

    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("INSERT INTO Course (title, description, locationNo, courseTypeNo, courseFeeNo, employeeNo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiii", $title, $description, $locationNo, $courseTypeNo, $courseFeeNo, $employeeNo);

    if ($stmt->execute()) {
        // Redirect to a success page or manage courses page
        header('Location: courses.php?success=Course added successfully.');
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
        }

        form {
            max-width: 500px;
            margin: 0 auto;
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
    </style>
</head>

<body>
    <h1>Add Course</h1>
    <form method="post" action="">
        <input type="text" name="title" placeholder="Course Title" required>
        <textarea name="description" placeholder="Course Description" required></textarea>
        <select name="locationNo" required>
            <option value="">Select Location</option>
            <?php foreach ($locations as $location) { ?>
                <option value="<?php echo $location['locationNo']; ?>"><?php echo $location['address']; ?></option>
                <!-- Use 'address' -->
            <?php } ?>
        </select>
        <input type="number" name="courseTypeNo" placeholder="Course Type No" required>
        <input type="number" name="courseFeeNo" placeholder="Course Fee No" required>
        <input type="number" name="employeeNo" placeholder="Employee No" required>
        <button type="submit">Add Course</button>
    </form>
</body>

</html>