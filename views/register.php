<?php
session_start();
require_once __DIR__ . '/../config/config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate input data
    if (!empty($name) && !empty($email) && !empty($password) && !empty($role)) {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() == 0) {
            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $password, $role])) {
                $success = "User registered successfully.";
            } else {
                $error = "Error registering user.";
            }
        } else {
            $error = "Email already exists.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            color: #343a40;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            color: #495057;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            margin: 0;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h2>Register</h2>
    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br>
        <label for="role">Role:</label><br>
        <select name="role" required>
            <option value="employee">Employee</option>
            <option value="manager">Manager</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>