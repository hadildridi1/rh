<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../config/config.php';

$userController = new UserController($conn);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
</head>
<body>
    <h1>Manage Users</h1>
    <form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name">

    <label for="email">Email:</label>
    <input type="text" id="email" name="email">

    <label for="role">Role:</label>
    <input type="text" id="role" name="role">

    <label for="department_id">Department ID:</label>
    <input type="text" id="department_id" name="department_id">

    <label for="min_salary">Min Salary:</label>
    <input type="text" id="min_salary" name="min_salary">

    <label for="max_salary">Max Salary:</label>
    <input type="text" id="max_salary" name="max_salary">

    <label for="sort_field">Sort By:</label>
    <select id="sort_field" name="sort_field">
        <option value="name">Name</option>
        <option value="email">Email</option>
        <option value="role">Role</option>
        <option value="department_id">Department ID</option>
        <option value="salary">Salary</option>
        <option value="age">Age</option>
    </select>

    <label for="sort_order">Order:</label>
    <select id="sort_order" name="sort_order">
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
    </select>

    <button type="submit">Search</button>
</form>

    <h2>Users</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department ID</th>
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
                    <td><?php echo htmlspecialchars($user['department_id']); ?></td>
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
</body>
</html>