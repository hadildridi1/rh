<?php
require_once __DIR__ . '/../controllers/UserController.php';

// Initialize database connection
$db = new PDO("mysql:host=localhost;dbname=rh", "root", "");

// Initialize UserController
$userController = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $department_id = $_POST['department_id'];

    $userController->update($id, $name, $email, $role, $department_id);
    header("Location: admin_view.php");
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
</head>
<body>
    <h1>Update User</h1>
    <form method="POST" action="update_user.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="manager" <?php if ($user['role'] == 'manager') echo 'selected'; ?>>Manager</option>
            <option value="employee" <?php if ($user['role'] == 'employee') echo 'selected'; ?>>Employee</option>
        </select><br>
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" value="<?php echo htmlspecialchars($user['department_id']); ?>" required><br>
        <button type="submit">Update User</button>
    </form>
</body>
</html>