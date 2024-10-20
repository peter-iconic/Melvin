<?php
session_start();
include('db.php'); // Database connection

if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseNo = $_POST['courseNo'];
    $clientID = $_SESSION['userID']; // Assume this is the client ID
    $registrationDate = date('Y-m-d');

    // Insert registration data
    $query = "INSERT INTO Registration (courseNo, clientID, registrationDate) VALUES ('$courseNo', '$clientID', '$registrationDate')";

    if (mysqli_query($conn, $query)) {
        echo "You have successfully registered for the course.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch available courses for the dropdown
$coursesQuery = "SELECT * FROM Course";
$coursesResult = mysqli_query($conn, $coursesQuery);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register for a Course</title>
</head>

<body>
    <h1>Register for a Course</h1>
    <form method="post" action="">
        <label for="courseNo">Select Course:</label>
        <select name="courseNo" id="courseNo" required>
            <?php while ($course = mysqli_fetch_assoc($coursesResult)) { ?>
                <option value="<?php echo $course['courseNo']; ?>">
                    <?php echo $course['courseName']; ?>
                </option>
            <?php } ?>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>