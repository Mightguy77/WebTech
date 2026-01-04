<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/StockLog. php';
require_once __DIR__ . '/../models/Order.php';

class EmployeeController {
    private $db;
    private $user;
    private $product;
    private $category;
    private $stockLog;
    private $order;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->product = new Product($this->db);
        $this->category = new Category($this->db);
        $this->stockLog = new StockLog($this->db);
        $this->order = new Order($this->db);
    }

    // Customer Management
    public function getCustomers() {
        return $this->user->getAllByRole('customer');
    }

    public function addCustomer($data) {
        if($this->user->usernameExists($data['username'])) {
            return ['success' => false, 'message' => 'Username already exists'];
        }
        
        if($this->user->emailExists($data['email'])) {
            return ['success' => false, 'message' => 'Email already exists'];
        }
        
        $this->user->username = $data['username'];
        $this->user->email = $data['email'];
        $this->user->password = $data['password'];
        $this->user->full_name = $data['full_name'];
        $this->user->phone = $data['phone'] ?? '';
        $this->user->address = $data['address'] ??  '';
        $this->user->role = 'customer';
        
        if($this->user->register()) {
            return ['success' => true, 'message' => 'Customer added successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to add customer'];
    }

    public function deleteCustomer($id) {
        if($this->user->delete($id)) {
            return ['success' => true, 'message' => 'Customer removed successfully'];
        }
        return ['success' => false, 'message' => 'Failed to remove customer'];
    }

    // Product Management
    public function getProducts() {
        return $this->product->getAll();
    }

    public function getCategories() {
        return $this->category->getAll();
    }

    public function addProduct($data, $employee_id) {
        $this->product->category_id = $data['category_id'];
        $this->product->name = $data['name'];
        $this->product->description = $data['description'];
        $this->product->specifications = $data['specifications'];
        $this->product->price = $data['price'];
        $this->product->stock_quantity = $data['stock_quantity'];
        $this->product->image = $data['image'] ?? 'default_product.png';
        $this->product->created_by = $employee_id;
        
        $product_id = $this->product->create();
        
        if($product_id) {
            // Log the initial stock
            if($data['stock_quantity'] > 0) {
                $this->stockLog->product_id = $product_id;
                $this->stockLog->employee_id = $employee_id;
                $this->stockLog->action_type = 'stock_in';
                $this->stockLog->quantity = $data['stock_quantity'];
                $this->stockLog->notes = 'Initial stock on product creation';
                $this->stockLog->create();
            }
            
            return ['success' => true, 'message' => 'Product added successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to add product'];
    }

    public function updateProduct($data) {
        $this->product->id = $data['id'];
        $this->product->category_id = $data['category_id'];
        $this->product->name = $data['name'];
        $this->product->description = $data['description'];
        $this->product->specifications = $data['specifications'];
        $this->product->price = $data['price'];
        $this->product->image = $data['image'] ?? 'default_product.png';
        
        if($this->product->update()) {
            return ['success' => true, 'message' => 'Product updated successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to update product'];
    }

    public function deleteProduct($id) {
        if($this->product->delete($id)) {
            return ['success' => true, 'message' => 'Product removed successfully'];
        }
        return ['success' => false, 'message' => 'Failed to remove product'];
    }

    // Inventory Management
    public function stockIn($product_id, $quantity, $employee_id, $notes = '') {
        if($this->product->updateStock($product_id, $quantity, 'stock_in')) {
            $this->stockLog->product_id = $product_id;
            $this->stockLog->employee_id = $employee_id;
            $this->stockLog->action_type = 'stock_in';
            $this->stockLog->quantity = $quantity;
            $this->stockLog->notes = $notes;
            $this->stockLog->create();
            
            return ['success' => true, 'message' => 'Stock added successfully'];
        }
        return ['success' => false, 'message' => 'Failed to add stock'];
    }

    public function stockOut($product_id, $quantity, $employee_id, $notes = '') {
        if($this->product->updateStock($product_id, $quantity, 'stock_out')) {
            $this->stockLog->product_id = $product_id;
            $this->stockLog->employee_id = $employee_id;
            $this->stockLog->action_type = 'stock_out';
            $this->stockLog->quantity = $quantity;
            $this->stockLog->notes = $notes;
            $this->stockLog->create();
            
            return ['success' => true, 'message' => 'Stock removed successfully'];
        }
        return ['success' => false, 'message' => 'Insufficient stock or failed to remove'];
    }

    // Price Management
    public function updatePrice($product_id, $price) {
        if($this->product->updatePrice($product_id, $price)) {
            return ['success' => true, 'message' => 'Price updated successfully'];
        }
        return ['success' => false, 'message' => 'Failed to update price'];
    }

    public function addOffer($product_id, $percentage) {
        if($this->product->addOffer($product_id, $percentage)) {
            return ['success' => true, 'message' => 'Offer added successfully'];
        }
        return ['success' => false, 'message' => 'Failed to add offer'];
    }

    public function removeOffer($product_id) {
        if($this->product->removeOffer($product_id)) {
            return ['success' => true, 'message' => 'Offer removed successfully'];
        }
        return ['success' => false, 'message' => 'Failed to remove offer'];
    }

    // Dashboard Stats
    public function getDashboardStats() {
        $products = $this->product->getAll();
        $customers = $this->user->getAllByRole('customer');
        $categories = $this->category->getAll();
        $orders = $this->order->getAll();
        
        $lowStock = array_filter($products, function($p) {
            return $p['stock_quantity'] < 10;
        });
        
        return [
            'total_products' => count($products),
            'total_customers' => count($customers),
            'total_categories' => count($categories),
            'total_orders' => count($orders),
            'low_stock_items' => count($lowStock)
        ];
    }
}
?>