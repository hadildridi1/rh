<?php
// PerformanceReviewController.php
require_once 'config.php';
require_once 'PerformanceReview.php';

class PerformanceReviewController {
    private $db;
    private $performanceReview;

    public function __construct($db) {
        $this->db = $db;
        $this->performanceReview = new PerformanceReview($db);
    }

    public function create($user_id, $review, $date) {
        $this->performanceReview->user_id = $user_id;
        $this->performanceReview->review = $review;
        $this->performanceReview->date = $date;
        return $this->performanceReview->create();
    }

    public function read() {
        return $this->performanceReview->read();
    }

    public function update($id, $user_id, $review, $date) {
        $this->performanceReview->id = $id;
        $this->performanceReview->user_id = $user_id;
        $this->performanceReview->review = $review;
        $this->performanceReview->date = $date;
        return $this->performanceReview->update();
    }

    public function delete($id) {
        $this->performanceReview->id = $id;
        return $this->performanceReview->delete();
    }
}
?>