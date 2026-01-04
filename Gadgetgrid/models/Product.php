<?php
class Product {
    private $conn;
    private $table = "products";

    public $id;
    public $category_id;
    public $name;
    public $description;
    public $specifications;
    public $price;
    public $offer_price;
    public $offer_percentage;
    public $stock_quantity;
    public $image;
    public $status;
    public $created_by;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all products
    public function getAll() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c. id 
                  WHERE p.status = 'active' 
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO:: FETCH_ASSOC);
    }

    // Get product by ID
    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c. id 
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO:: FETCH_ASSOC);
    }

    // Get products by category
    public function getByCategory($category_id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.category_id = :category_id AND p.status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO:: FETCH_ASSOC);
    }

    // Search products
    public function search($keyword) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c. id 
                  WHERE p.status = 'active' AND (p.name LIKE :keyword OR c. name LIKE :keyword OR p.description LIKE :keyword)";
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create product
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET category_id=:category_id, name=:name, description=:description, 
                      specifications=: specifications, price=: price, stock_quantity=:stock_quantity, 
                      image=: image, created_by=:created_by";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(": category_id", $this->category_id);
        $stmt->bindParam(": name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":specifications", $this->specifications);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":stock_quantity", $this->stock_quantity);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(": created_by", $this->created_by);
        
        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Update product
    public function update() {
        $query = "UPDATE " .  $this->table .  " 
                  SET category_id=:category_id, name=:name, description=:description, 
                      specifications=:specifications, price=:price, image=:image 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":specifications", $this->specifications);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(": image", $this->image);
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }

    // Update stock
    public function updateStock($id, $quantity, $action) {
        if($action == 'stock_in') {
            $query = "UPDATE " . $this->table . " SET stock_quantity = stock_quantity + :quantity WHERE id = :id";
        } else {
            $query = "UPDATE " .  $this->table .  " SET stock_quantity = stock_quantity - :quantity WHERE id = :id AND stock_quantity >= :quantity";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(": id", $id);
        
        return $stmt->execute();
    }

    // Update price
    public function updatePrice($id, $price) {
        $query = "UPDATE " . $this->table . " SET price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Add offer
    public function addOffer($id, $percentage) {
        $product = $this->getById($id);
        $offer_price = $product['price'] - ($product['price'] * $percentage / 100);
        
        $query = "UPDATE " . $this->table . " SET offer_percentage = :percentage, offer_price = : offer_price WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":percentage", $percentage);
        $stmt->bindParam(":offer_price", $offer_price);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Remove offer
    public function removeOffer($id) {
        $query = "UPDATE " . $this->table . " SET offer_percentage = 0, offer_price = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Delete product
    public function delete($id) {
        $query = "UPDATE " . $this->table . " SET status = 'inactive' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Get products with offers
    public function getProductsWithOffers() {
        $query = "SELECT p. *, c.name as category_name 
                  FROM " .  $this->table .  " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.status = 'active' AND p.offer_percentage > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>