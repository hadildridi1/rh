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
</head>
<body>
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
</body>
</html>