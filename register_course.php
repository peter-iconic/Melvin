<?php
session_start();
include('db.php');
if ($_SESSION['role'] != 'client') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseNo = $_POST['courseNo'];
    $delegateNo = $_SESSION['userID']; // Assuming delegateNo is same as userID in this case
    $employeeNo = 1; // Example employee handling registration

    $query = "INSERT INTO Registration (courseNo, delegateNo, employeeNo)
              VALUES ('$courseNo', '$delegateNo', '$employeeNo')";
    if (mysqli_query($conn, $query)) {
        echo "Registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register for a Course</title>
</head>

<body>
    <h1>Available Courses</h1>
    <form method="post" action="">
        <label for="courseNo">Select Course:</label>
        <select name="courseNo">
            <?php
            $courses = mysqli_query($conn, "SELECT * FROM Course");
            while ($row = mysqli_fetch_assoc($courses)) {
                echo "<option value='{$row['courseNo']}'>{$row['title']}</option>";
            }
            ?>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>