<?php
require_once __DIR__ . '/../controllers/UserController.php';

// Initialize database connection
$db = new PDO("mysql:host=localhost;dbname=rh", "root", "");

// Initialize UserController
$userController = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $department_id = $_POST['department_id'];
    $salary = $_POST['salary'];
    $age = $_POST['age'];

    $userController->update($id, $name, $email, $role, $department_id, $salary, $age);
    header("Location: admin_user.php");
    exit();
} else {
    $id = $_GET['id'];
    $user = $userController->readById($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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
            gap: 10px;
        }
        form label {
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        form input[type="text"],
        form input[type="email"],
        form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
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
        label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
    box-sizing: border-box;
}

input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Update User</h1>
        <form method="POST" action="update_user.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required>
            <label for="department_id">Department ID:</label>
            <input type="text" id="department_id" name="department_id" value="<?php echo htmlspecialchars($user['department_id']); ?>">
            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($user['salary']); ?>" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>