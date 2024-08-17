<?php
// User.php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $role;
    public $department_id;
    public $salary;
    public $age;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, email=:email, role=:role, department_id=:department_id, salary=:salary, age=:age";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':department_id', $this->department_id);
        $stmt->bindParam(':salary', $this->salary);
        $stmt->bindParam(':age', $this->age);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readById() {
        $query = "SELECT id, name, email, role, department_id, salary, age FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function search($criteria) {
        // Check if criteria is empty
        if (empty($criteria)) {
            return [];
        }
    
        // Assuming $criteria is an associative array with column names as keys and search values as values
        $query = "SELECT * FROM " . $this->table . " WHERE ";
        $conditions = [];
        $params = [];
        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(' AND ', $conditions);
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function averageSalary() {
        $query = "SELECT AVG(salary) as average_salary FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['average_salary'];
    }
    
    public function averageAge() {
        $query = "SELECT AVG(age) as average_age FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['average_age'];
    }
    public function usersPerDepartment() {
        $query = "SELECT department_id, COUNT(*) as user_count FROM users GROUP BY department_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function highestSalary() {
        $query = "SELECT MAX(salary) as highest_salary FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['highest_salary'];
    }

    public function lowestSalary() {
        $query = "SELECT MIN(salary) as lowest_salary FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['lowest_salary'];
    }
}
?>