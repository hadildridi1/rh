<?php
// UserController.php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
    }

    // Create a new user
    public function create($name, $email, $role, $department_id, $salary, $age) {
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;
        $this->user->department_id = $department_id;
        $this->user->salary = $salary;
        $this->user->age = $age;
        return $this->user->create();
    }

    // Read all users
    public function read() {
        return $this->user->read();
    }

    // Read a single user by ID
    public function readById($id) {
        $this->user->id = $id;
        return $this->user->readById();
    }

    // Update an existing user
    public function update($id, $name, $email, $role, $department_id, $salary, $age) {
        $this->user->id = $id;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;
        $this->user->department_id = $department_id;
        $this->user->salary = $salary;
        $this->user->age = $age;
        return $this->user->update();
    }

    // Delete a user
    public function delete($id) {
        $this->user->id = $id;
        return $this->user->delete();
    }

    // Search users based on criteria
    public function search($criteria) {
        return $this->user->search($criteria);
    }

    // Count total users
    public function count() {
        return $this->user->count();
    }

    // Calculate average salary
    public function averageSalary() {
        return $this->user->averageSalary();
    }

    // Calculate average age
    public function averageAge() {
        return $this->user->averageAge();
    }
    public function usersPerDepartment() {
        return $this->user->usersPerDepartment();
    }

    public function highestSalary() {
        return $this->user->highestSalary();
    }

    public function lowestSalary() {
        return $this->user->lowestSalary();
    }
}
?>