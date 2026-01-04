<?php
class Wishlist {
    private $conn;
    private $table = "wishlist";

    public $id;
    public $customer_id;
    public $product_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add to wishlist
    public function add($customer_id, $product_id) {
        $query = "INSERT IGNORE INTO " . $this->table . " SET customer_id=:customer_id, product_id=:product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->bindParam(":product_id", $product_id);
        return $stmt->execute();
    }

    // Remove from wishlist
    public function remove($customer_id, $product_id) {
        $query = "DELETE FROM " .  $this->table .  " WHERE customer_id=:customer_id AND product_id=:product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->bindParam(":product_id", $product_id);
        return $stmt->execute();
    }

    // Get customer wishlist
    public function getByCustomer($customer_id) {
        $query = "SELECT w.*, p.name, p.price, p.offer_price, p.image, p.stock_quantity, c.name as category_name 
                  FROM " . $this->table . " w 
                  LEFT JOIN products p ON w.product_id = p. id 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE w.customer_id = :customer_id AND p.status = 'active'
                  ORDER BY w.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check if product is in wishlist
    public function isInWishlist($customer_id, $product_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE customer_id=: customer_id AND product_id=:product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>