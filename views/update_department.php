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

if (!isset($_GET['id'])) {
    die("Department ID is required.");
}

$department_id = $_GET['id'];
$department = $departmentController->readById($department_id);

if (!$department) {
    die("Department not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    if ($departmentController->update($department_id, $name, $category_id)) {
        header("Location: manage_departments.php");
        exit();
    } else {
        $error = "Failed to update department.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Department</title>
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
            gap: 15px;
            max-width: 100%;
            margin: 0 auto;
        }
        form label {
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        form input[type="text"],
        form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
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
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Department</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="name">Department Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($department['name']); ?>" required>
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $category['id'] == $department['category_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Update Department</button>
        </form>
        <a href="manage_departments.php" class="back-link">Back to Manage Departments</a>
    </div>
</body>
</html>