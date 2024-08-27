<?php
class PerformanceReview {
    private $id;
    private $user_id;
    private $review;
    private $date;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getReview() {
        return $this->review;
    }

    public function getDate() {
        return $this->date;
    }

    // Fetch reviews by user ID
    public static function getByUserId($user_id) {
        global $conn; // Assuming $conn is your PDO database connection

        $query = "SELECT * FROM performance_reviews WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $reviews = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $review = new self();
            $review->id = $row['id'];
            $review->user_id = $row['user_id'];
            $review->review = $row['review'];
            $review->date = $row['date'];
            $reviews[] = $review;
        }

        return $reviews;
    }

    // Create a new performance review
    public static function create($user_id, $review, $date) {
        global $conn;

        $query = "INSERT INTO performance_reviews (user_id, review, date) VALUES (:user_id, :review, :date)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Read all performance reviews
    public static function read() {
        global $conn;

        $query = "SELECT * FROM performance_reviews";
        $stmt = $conn->query($query);

        $reviews = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $review = new self();
            $review->id = $row['id'];
            $review->user_id = $row['user_id'];
            $review->review = $row['review'];
            $review->date = $row['date'];
            $reviews[] = $review;
        }

        return $reviews;
    }

    // Update a performance review
    public static function update($id, $user_id, $review, $date) {
        global $conn;

        $query = "UPDATE performance_reviews SET user_id = :user_id, review = :review, date = :date WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete a performance review
    public static function delete($id) {
        global $conn;

        $query = "DELETE FROM performance_reviews WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>