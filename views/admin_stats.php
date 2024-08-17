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
    <title>Admin Stats</title>
    <style>
        .stats {
            margin-bottom: 20px;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
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
                <li>Department ID <?php echo $department['department_id']; ?>: <?php echo $department['user_count']; ?> user(s)</li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="buttons">
        <button onclick="location.href='admin_user.php'">Manage Users</button>
        <button onclick="location.href='manage_departments.php'">Manage Departments</button>
    </div>
</body>
</html>