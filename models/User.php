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
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, email=:email, role=:role, department_id=:department_id, salary=:salary, age=:age, password=:password";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':department_id', $this->department_id);
        $stmt->bindParam(':salary', $this->salary);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':password', $this->password);

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
        $query = "SELECT id, name, email, role, department_id, salary, age, password FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
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
        $query = "
        SELECT d.name as department_name, COUNT(u.id) as user_count
        FROM departments d
        LEFT JOIN users u ON d.id = u.department_id
        GROUP BY d.id";        
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
    
   
    public function searchUsers($criteria) {
        $query = "SELECT users.* FROM users";
        $params = [];
    
        if (!empty($criteria['department_name'])) {
            $query .= " LEFT JOIN departments ON users.department_id = departments.id";
        }
    
        $query .= " WHERE 1=1";
    
        if (!empty($criteria['name'])) {
            $query .= " AND users.name LIKE :name";
            $params[':name'] = '%' . $criteria['name'] . '%';
        }
    
        if (!empty($criteria['email'])) {
            $query .= " AND users.email LIKE :email";
            $params[':email'] = '%' . $criteria['email'] . '%';
        }
    
        if (!empty($criteria['department_name'])) {
            $query .= " AND departments.name LIKE :department_name";
            $params[':department_name'] = '%' . $criteria['department_name'] . '%';
        }
        if (!empty($criteria['role'])) {
            $query .= " AND users.role LIKE :role";
            $params[':role'] = '%' . $criteria['role'] . '%';
        }
    
        if (!empty($criteria['min_salary'])) {
            $query .= " AND users.salary >= :min_salary";
            $params[':min_salary'] = $criteria['min_salary'];
        }
    
        if (!empty($criteria['max_salary'])) {
            $query .= " AND users.salary <= :max_salary";
            $params[':max_salary'] = $criteria['max_salary'];
        }
    
        if (!empty($criteria['sort_field']) && !empty($criteria['sort_order'])) {
            $query .= " ORDER BY " . $criteria['sort_field'] . " " . $criteria['sort_order'];
        }
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($name, $email, $password) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $password, $this->id]);
    }
    

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, email = :email, role = :role, department_id = :department_id, salary = :salary, age = :age 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->department_id = htmlspecialchars(strip_tags($this->department_id));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':department_id', $this->department_id);
        $stmt->bindParam(':salary', $this->salary);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getPerformanceReviewsByEmployeeId($employee_id) {
        $stmt = $this->conn->prepare("SELECT * FROM performance_reviews WHERE user_id = ?");
        $stmt->execute([$employee_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>