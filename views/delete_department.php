<?php
require_once __DIR__ . '/../controllers/DepartmentController.php';

// Initialize database connection
try {
    $db = new PDO("mysql:host=localhost;dbname=rh", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize DepartmentController
$departmentController = new DepartmentController($db);

if (!isset($_GET['id'])) {
    die("Department ID is required.");
}

$department_id = $_GET['id'];

if ($departmentController->delete($department_id)) {
    header("Location: manage_departments.php");
    exit();
} else {
    die("Failed to delete department.");
}
?>