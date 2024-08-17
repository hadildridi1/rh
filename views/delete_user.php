<?php
require_once __DIR__ . '/../controllers/UserController.php';

// Initialize database connection
$db = new PDO("mysql:host=localhost;dbname=rh", "root", "");

// Initialize UserController
$userController = new UserController($db);

$id = $_GET['id'];
$userController->delete($id);

header("Location: admin_view.php");
exit();
?>