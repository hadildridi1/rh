<?php
require_once __DIR__ . '/../controllers/DepartmentController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';

// Initialize database connection
try {
    $db = new PDO("mysql:host=localhost;dbname=rh", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize DepartmentController and CategoryController
$departmentController = new DepartmentController($db);
$categoryController = new CategoryController($db);

// Fetch all categories
$categories = $categoryController->read();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    if ($departmentController->create($name, $category_id)) {
        header("Location: manage_departments.php");
        exit();
    } else {
        $error = "Failed to add department.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
</head>
<body>
    <h1>Add Department</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="name">Department Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br>
        <button type="submit">Add Department</button>
    </form>
    <a href="manage_departments.php">Back to Manage Departments</a>
</body>
</html>