<?php
// Include necessary files and initialize controllers
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/DepartmentController.php';
require_once __DIR__ . '/../config/config.php'; // Assuming you have a Database.php file for the DB connection


// Initialize controllers with the existing database connection
$userController = new UserController($conn);
$departmentController = new DepartmentController($conn);

// Fetch statistics
$userCount = $userController->count();
$departmentCount = $departmentController->count();
$averageSalary = $userController->averageSalary();
$averageAge = $userController->averageAge();
$usersPerDepartment = $userController->usersPerDepartment();
$highestSalary = $userController->highestSalary();
$lowestSalary = $userController->lowestSalary();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Statistics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .stats {
            margin: 20px 0;
        }
        .stats p {
            font-size: 18px;
            color: #555;
        }
        .stats h2 {
            margin-top: 30px;
            color: #333;
        }
        .stats ul {
            list-style-type: none;
            padding: 0;
        }
        .stats ul li {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }
        .buttons {
            text-align: center;
            margin-top: 30px;
        }
        .buttons button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
            border-radius: 5px;
        }
        .buttons button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Statistics</h1>
        <div class="stats">
            <p>Total Users: <?php echo $userCount; ?></p>
            <p>Total Departments: <?php echo $departmentCount; ?></p>
            <p>Average Salary: <?php echo $averageSalary; ?></p>
            <p>Average Age: <?php echo $averageAge; ?></p>
            <p>Highest Salary: <?php echo $highestSalary; ?></p>
            <p>Lowest Salary: <?php echo $lowestSalary; ?></p>
            <h2>Users Per Department</h2>
            <ul>
                <?php foreach ($usersPerDepartment as $department): ?>
                    <li>Department: <?php echo htmlspecialchars($department['department_name']); ?>: <?php echo htmlspecialchars($department['user_count']); ?> user(s)</li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="buttons">
            <button onclick="location.href='admin_user.php'">Manage Users</button>
            <button onclick="location.href='manage_departments.php'">Manage Departments</button>
        </div>
    </div>
</body>
</html>