<?php
require_once __DIR__ . '/../controllers/UserController.php';

// Initialize database connection
$db = new PDO("mysql:host=localhost;dbname=rh", "root", "");

// Initialize UserController
$userController = new UserController($db);

// Fetch all users
$users = $userController->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #000;
            border-radius: 3px;
            margin: 2px;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
        }
        .btn-update {
            background-color: #FFA500;
            color: white;
        }
        .btn-delete {
            background-color: #FF0000;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Manage Users</h1>
    <a href="add_user.php" class="btn btn-add">Add New User</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['department_id']); ?></td>
                    <td>
                        <a href="update_user.php?id=<?php echo $user['id']; ?>" class="btn btn-update">Update</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>