<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../config/config.php';

$userController = new UserController($conn);

function getDepartmentNameById($id, $conn) {
    $query = "SELECT name FROM departments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}


$users = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criteria = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'role' => $_POST['role'] ?? '',
        'department_id' => $_POST['department_id'] ?? '',
        'min_salary' => $_POST['min_salary'] ?? '',
        'max_salary' => $_POST['max_salary'] ?? '',
        'sort_field' => $_POST['sort_field'] ?? '',
        'sort_order' => $_POST['sort_order'] ?? ''
    ];
    $users = $userController->searchUsers($criteria);
   
} else {
    $users = $userController->getAllUsers();
    
}
foreach ($users as &$user) {
    $user['department_name'] = getDepartmentNameById($user['department_id'], $conn);
}
unset($user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
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
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        form .form-group {
            flex: 1 1 calc(33.33% - 10px);
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        form input[type="text"],
        form select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }
        form button {
            flex: 1 1 100%;
            padding: 8px 10px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-update {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Users</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" id="role" name="role">
            </div>
            <div class="form-group">
                <label for="department_id">Department ID:</label>
                <input type="text" id="department_id" name="department_id">
            </div>
            <div class="form-group">
                <label for="min_salary">Min Salary:</label>
                <input type="text" id="min_salary" name="min_salary">
            </div>
            <div class="form-group">
                <label for="max_salary">Max Salary:</label>
                <input type="text" id="max_salary" name="max_salary">
            </div>
            <div class="form-group">
                <label for="sort_field">Sort By:</label>
                <select id="sort_field" name="sort_field">
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="role">Role</option>
                    <option value="department_id">Department ID</option>
                    <option value="salary">Salary</option>
                    <option value="age">Age</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sort_order">Order:</label>
                <select id="sort_order" name="sort_order">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <button type="submit">Search</button>
        </form>

        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['department_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['salary']); ?></td>
                        <td><?php echo htmlspecialchars($user['age']); ?></td>
                        <td>
                            <a href="update_user.php?id=<?php echo $user['id']; ?>" class="btn btn-update">Update</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
