<?php
// Assuming you have a database connection file
require_once __DIR__ . '/../config/config.php'; // Assuming you have a Database.php file for the DB connection
require_once __DIR__ . '/../controllers/PerformanceReviewController.php';
require_once __DIR__ . '/../models/PerformanceReview.php';

$user_id = $_GET['user_id'];

// Instantiate the controller with the database connection
$performanceReviewController = new PerformanceReviewController($conn);

// Handle form submission for adding a review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $review = $_POST['review'];
    $date = $_POST['date'];
    $performanceReviewController->create($user_id, $review, $date);
}

// Handle deletion of a review
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $performanceReviewController->delete($delete_id);
}

// Fetch performance reviews for the specific user
$performanceReviews = $performanceReviewController->getReviewsByUserId($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Performance Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h1 {
            color: #343a40;
        }
        .btn-back, .btn-add, .btn-delete {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        .btn-add {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            cursor: pointer;
        }
        .form-container {
            display: none;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function toggleForm() {
            var formContainer = document.getElementById('form-container');
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Performance Reviews for User ID: <?php echo htmlspecialchars($user_id); ?></h1>
        <a href="manager_view.php" class="btn-back">Back to Employee Management</a>
        <button class="btn-add" onclick="toggleForm()">Add Review</button>
        <div id="form-container" class="form-container">
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                <label for="review">Review:</label><br>
                <textarea name="review" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 10px; border: 1px solid #ced4da; border-radius: 4px;"></textarea><br>
                <label for="date">Date:</label><br>
                <input type="date" name="date" required value="<?php echo date('Y-m-d'); ?>" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 10px; border: 1px solid #ced4da; border-radius: 4px;"><br><br>
                <button type="submit" class="btn-add" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($performanceReviews as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review->getId()); ?></td>
                    <td><?php echo htmlspecialchars($review->getReview()); ?></td>
                    <td><?php echo htmlspecialchars($review->getDate()); ?></td>
                    <td>
                        <a href="?user_id=<?php echo htmlspecialchars($user_id); ?>&delete_id=<?php echo htmlspecialchars($review->getId()); ?>" class="btn-delete">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>