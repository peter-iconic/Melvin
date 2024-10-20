<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $role = $_POST['role'];

    $query = "INSERT INTO Users (username, password, role) VALUES ('$username', '$password', '$role')";

    if (mysqli_query($conn, $query)) {
        // Redirect to home page after successful registration
        header("Location: home.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register User</title>
</head>

<body>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="client">Client</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>