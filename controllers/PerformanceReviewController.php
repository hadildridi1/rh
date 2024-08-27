<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/PerformanceReview.php';

class PerformanceReviewController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getReviewsByUserId($user_id) {
        return PerformanceReview::getByUserId($user_id);
    }

    public function create($user_id, $review, $date) {
        return PerformanceReview::create($user_id, $review, $date);
    }

    public function read() {
        return PerformanceReview::read();
    }

    public function update($id, $user_id, $review, $date) {
        return PerformanceReview::update($id, $user_id, $review, $date);
    }

    public function delete($id) {
        return PerformanceReview::delete($id);
    }
}
?>