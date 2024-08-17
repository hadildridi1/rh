<?php
// UserController.php
require_once 'config.php';
require_once 'User.php';

class UserController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
    }

    public function create($name, $email, $role, $department_id) {
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;
        $this->user->department_id = $department_id;
        return $this->user->create();
    }

    public function read() {
        return $this->user->read();
    }

    public function update($id, $name, $email, $role, $department_id) {
        $this->user->id = $id;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;
        $this->user->department_id = $department_id;
        return $this->user->update();
    }

    public function delete($id) {
        $this->user->id = $id;
        return $this->user->delete();
    }
}
?>