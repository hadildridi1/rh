<?php
// DepartmentController.php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/Departement.php';    

class DepartmentController {
    private $db;
    private $department;

    public function __construct($db) {
        $this->db = $db;
        $this->department = new Department($db);
    }

    public function create($name, $category_id) {
        $this->department->name = $name;
        $this->department->category_id = $category_id;
        return $this->department->create();
    }

    public function read() {
        return $this->department->read();
    }
    public function readById($id) {
        $this->department->id = $id;
        return $this->department->readById();
    }

    public function update($id, $name, $category_id) {
        $this->department->id = $id;
        $this->department->name = $name;
        $this->department->category_id = $category_id;
        return $this->department->update();
    }

    public function delete($id) {
        $this->department->id = $id;
        return $this->department->delete();
    }
    public function count() {
        $query = "SELECT COUNT(*) as count FROM departments";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>