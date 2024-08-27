<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/UserController.php';

if (!isset($_SESSION['employee_id'])) {
    die("Error: Employee ID not set in session.");
}

$employee_id = $_SESSION['employee_id'];
$userController = new UserController($conn);
$employee = $userController->getUserById($employee_id);
$performanceReviews = $userController->getPerformanceReviewsByEmployeeId($employee_id);


if (!$employee) {
    die("Error: User not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_info') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userController->updateUser($employee_id, $name, $email, $password)) {
        $employee = $userController->getUserById($employee_id); // Refresh employee data
        $success = "Information updated successfully.";
    } else {
        $error = "Failed to update information.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<div class="section">
       
    <title>Employee View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .section {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h2 {
            color: #343a40;
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
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .btn-update {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-update:hover {
            background-color: #0056b3;
        }
        .btn-logout {
            background-color: #dc3545;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-logout:hover {
            background-color: #c82333; ;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        p {
            margin: 0;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="section">
        <h2>Personal Information</h2>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update_info">
            <label for="name">Name:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 10px; border: 1px solid #ced4da; border-radius: 4px;"><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 10px; border: 1px solid #ced4da; border-radius: 4px;"><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 10px; border: 1px solid #ced4da; border-radius: 4px;"><br><br>
            <button type="submit" class="btn-update">Update Information</button>
            
    </div>
        </form>
        <form method="POST" action="logout.php">
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>

    <div class="section">
        <h2>Performance Reviews</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Review</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($performanceReviews)): ?>
                    <?php foreach ($performanceReviews as $review): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($review['id']); ?></td>
                        <td><?php echo htmlspecialchars($review['review']); ?></td>
                        <td><?php echo htmlspecialchars($review['date']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No performance reviews found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>