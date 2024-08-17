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

// Fetch all departments and categories
$departments = $departmentController->read();
$categories = $categoryController->read();

$success = null;
$error = null;

// Handle category addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    if ($categoryController->create($category_name)) {
        $success = "Category added successfully.";
    } else {
        $error = "Failed to add category.";
    }
}

// Handle category update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    if ($categoryController->update($category_id, $category_name)) {
        $success = "Category updated successfully.";
    } else {
        $error = "Failed to update category.";
    }
}

// Handle category deletion
if (isset($_GET['delete_category_id'])) {
    $category_id = $_GET['delete_category_id'];
    if ($categoryController->delete($category_id)) {
        $success = "Category deleted successfully.";
    } else {
        $error = "Failed to delete category.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Departments and Categories</title>
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
        .hidden {
            display: none;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
    <script>
        function toggleCategoryForm() {
            var form = document.getElementById('addCategoryForm');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
</head>
<body>
    <h1>Manage Departments and Categories</h1>

    <?php if ($success): ?>
        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <a href="add_department.php" class="btn btn-add">Add New Department</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($department = $departments->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($department['id']); ?></td>
                    <td><?php echo htmlspecialchars($department['name']); ?></td>
                    <td>
                        <?php
                        $category = $categoryController->readById($department['category_id']);
                        echo htmlspecialchars($category['name']);
                        ?>
                    </td>
                    <td>
                        <a href="update_department.php?id=<?php echo $department['id']; ?>" class="btn btn-update">Update</a>
                        <a href="delete_department.php?id=<?php echo $department['id']; ?>" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Categories</h2>
    <button class="btn btn-add" onclick="toggleCategoryForm()">Add New Category</button>
    <form id="addCategoryForm" class="hidden" method="post">
        <input type="text" name="category_name" placeholder="Category Name" required>
        <button type="submit" name="add_category" class="btn btn-add">Add Category</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                            <input type="text" name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                            <button type="submit" name="update_category" class="btn btn-update">Update</button>
                        </form>
                        <a href="?delete_category_id=<?php echo $category['id']; ?>" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>