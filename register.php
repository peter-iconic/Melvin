<?php
include('db.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Prevent SQL Injection
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password securely
    $role = $_POST['role'];

    // Check if username already exists
    $checkQuery = "SELECT * FROM Users WHERE username = ?";
    if ($stmtCheck = mysqli_prepare($conn, $checkQuery)) {
        mysqli_stmt_bind_param($stmtCheck, 's', $username);
        mysqli_stmt_execute($stmtCheck);
        mysqli_stmt_store_result($stmtCheck);

        if (mysqli_stmt_num_rows($stmtCheck) > 0) {
            echo "Error: Username already exists.";
        } else {
            // Insert the new user into the Users table
            $query = "INSERT INTO Users (username, password, role) VALUES (?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $role);
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to home page after successful registration
                    header("Location: home.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
    } else {
        echo "Error: Could not check username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
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
    <h1>Create a New User</h1>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="client">Client</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>