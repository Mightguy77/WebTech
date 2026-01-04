<?php
class StockLog {
    private $conn;
    private $table = "stock_logs";

    public $id;
    public $product_id;
    public $employee_id;
    public $action_type;
    public $quantity;
    public $notes;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create log
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET product_id=:product_id, employee_id=:employee_id, 
                      action_type=:action_type, quantity=: quantity, notes=: notes";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":employee_id", $this->employee_id);
        $stmt->bindParam(":action_type", $this->action_type);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":notes", $this->notes);
        
        return $stmt->execute();
    }

    // Get all logs (for admin)
    public function getAll() {
        $query = "SELECT sl.*, p.name as product_name, u.full_name as employee_name 
                  FROM " .  $this->table .  " sl 
                  LEFT JOIN products p ON sl.product_id = p.id 
                  LEFT JOIN users u ON sl.employee_id = u.id 
                  ORDER BY sl.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO:: FETCH_ASSOC);
    }

    // Get logs by employee
    public function getByEmployee($employee_id) {
        $query = "SELECT sl.*, p. name as product_name 
                  FROM " . $this->table . " sl 
                  LEFT JOIN products p ON sl.product_id = p. id 
                  WHERE sl.employee_id = :employee_id 
                  ORDER BY sl.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(": employee_id", $employee_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get logs by product
    public function getByProduct($product_id) {
        $query = "SELECT sl.*, u.full_name as employee_name 
                  FROM " .  $this->table .  " sl 
                  LEFT JOIN users u ON sl.employee_id = u.id 
                  WHERE sl.product_id = :product_id 
                  ORDER BY sl.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO:: FETCH_ASSOC);
    }
}
?>