<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $phone;
    public $address;
    public $role;
    public $status;
    public $profile_image;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register() {
        $query = "INSERT INTO " . $this->table . " 
                  SET username=:username, email=:email, password=:password, 
                      full_name=: full_name, phone=:phone, address=:address, 
                      role=:role, status=:status";
        
        $stmt = $this->conn->prepare($query);
        
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $this->status = ($this->role == 'employee') ? 'pending' : 'approved';
        
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(": address", $this->address);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":status", $this->status);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Login user
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username OR email = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO:: FETCH_ASSOC);
            if(password_verify($password, $row['password'])) {
                if($row['status'] == 'approved') {
                    return $row;
                } else {
                    return ['error' => 'Account pending approval or rejected'];
                }
            }
        }
        return false;
    }

    // Get user by ID
    public function getById($id) {
        $query = "SELECT * FROM " .  $this->table .  " WHERE id = : id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(": id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all users by role
    public function getAllByRole($role) {
        $query = "SELECT * FROM " . $this->table . " WHERE role = :role ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get pending employees
    public function getPendingEmployees() {
        $query = "SELECT * FROM " . $this->table . " WHERE role = 'employee' AND status = 'pending' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update user status
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Update profile
    public function updateProfile() {
        $query = "UPDATE " .  $this->table .  " 
                  SET full_name=:full_name, phone=:phone, address=:address, profile_image=:profile_image 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":profile_image", $this->profile_image);
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }

    // Change password
    public function changePassword($id, $newPassword) {
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt->bindParam(": password", $hashedPassword);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Delete user
    public function delete($id) {
        $query = "DELETE FROM " .  $this->table .  " WHERE id = : id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(": id", $id);
        return $stmt->execute();
    }

    // Check if username exists
    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Check if email exists
    public function emailExists($email) {
        $query = "SELECT id FROM " .  $this->table .  " WHERE email = : email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(": email", $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>