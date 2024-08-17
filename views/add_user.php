<?php
require_once __DIR__ . '/../controllers/UserController.php';

// Initialize database connection
$db = new PDO("mysql:host=localhost;dbname=rh", "root", "");

// Initialize UserController
$userController = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $department_id = $_POST['department_id'];

    $userController->create($name, $email, $role, $department_id);
    header("Location: admin_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 5px;
            max-width: 100%;
            margin: 0 auto;
        }
        form label {
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }
        form button {
            padding: 10px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fff;
            color: #333;
        }
        select:focus {
            border-color: #007bff;
            outline: none;
        }
        #department_id {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fff;
            color: #333;
        }
        #department_id:focus {
            border-color: #007bff;
            outline: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Add New User</h1>
    <form method="POST" action="add_user.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="employee">Employee</option>
        </select><br>
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required><br>
        <button type="submit">Add User</button>
    </form>
    </div>
</body>
</html>