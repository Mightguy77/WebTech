<?php
class Order {
    private $conn;
    private $table = "orders";

    public $id;
    public $customer_id;
    public $total_amount;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create order
    public function create() {
        $query = "INSERT INTO " . $this->table . " SET customer_id=: customer_id, total_amount=:total_amount";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":total_amount", $this->total_amount);
        
        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Add order item
    public function addItem($order_id, $product_id, $quantity, $price) {
        $query = "INSERT INTO order_items SET order_id=:order_id, product_id=:product_id, quantity=:quantity, price=:price";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(": quantity", $quantity);
        $stmt->bindParam(":price", $price);
        return $stmt->execute();
    }

    // Get orders by customer
    public function getByCustomer($customer_id) {
        $query = "SELECT o.*, 
                  (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) as item_count
                  FROM " .  $this->table .  " o 
                  WHERE o.customer_id = :customer_id 
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO:: FETCH_ASSOC);
    }

    // Get order details
    public function getOrderDetails($order_id) {
        $query = "SELECT oi.*, p. name as product_name, p.image 
                  FROM order_items oi 
                  LEFT JOIN products p ON oi.product_id = p.id 
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update order status
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Get all orders (for employee)
    public function getAll() {
        $query = "SELECT o.*, u.full_name as customer_name, u.email as customer_email,
                  (SELECT COUNT(*) FROM order_items WHERE order_id = o. id) as item_count
                  FROM " . $this->table . " o 
                  LEFT JOIN users u ON o. customer_id = u.id 
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>