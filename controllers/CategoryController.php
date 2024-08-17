<?php
// CategoryController.php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/Category.php';

class CategoryController {
    public $db;
    public $category;

    public function __construct($db) {
        $this->db = $db;
        $this->category = new Category($db);
    }

    public function create($name) {
        $this->category->name = $name;
        return $this->category->create();
    }
    public function readById($id) {
        $this->category->id = $id;
        return $this->category->readById();
    }
    public function read() {
        return $this->category->read();
    }

    public function update($id, $name) {
        $this->category->id = $id;
        $this->category->name = $name;
        return $this->category->update();
    }

    public function delete($id) {
        $this->category->id = $id;
        return $this->category->delete();
    }
}
?>