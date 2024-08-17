<?php
// CategoryController.php
require_once 'config.php';
require_once 'Category.php';

class CategoryController {
    private $db;
    private $category;

    public function __construct($db) {
        $this->db = $db;
        $this->category = new Category($db);
    }

    public function create($name) {
        $this->category->name = $name;
        return $this->category->create();
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