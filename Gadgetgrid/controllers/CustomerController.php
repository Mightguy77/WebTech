<?php
require_once __DIR__ . '/../config/database. php';
require_once __DIR__ .  '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Wishlist.php';
require_once __DIR__ . '/../models/User.php';

class CustomerController {
    private $db;
    private $product;
    private $category;
    private $order;
    private $wishlist;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
        $this->category = new Category($this->db);
        $this->order = new Order($this->db);
        $this->wishlist = new Wishlist($this->db);
        $this->user = new User($this->db);
    }

    // Product Browsing
    public function getProducts() {
        return $this->product->getAll();
    }

    public function getProductById($id) {
        return $this->product->getById($id);
    }

    public function getProductsByCategory($category_id) {
        return $this->product->getByCategory($category_id);
    }

    public function searchProducts($keyword) {
        return $this->product->search($keyword);
    }

    public function getCategories() {
        return $this->category->getAll();
    }

    public function getProductsWithOffers() {
        return $this->product->getProductsWithOffers();
    }

    // Order Management
    public function getOrders($customer_id) {
        return $this->order->getByCustomer($customer_id);
    }

    public function getOrderDetails($order_id) {
        return $this->order->getOrderDetails($order_id);
    }

    public function placeOrder($customer_id, $items) {
        $total = 0;
        foreach($items as $item) {
            $product = $this->product->getById($item['product_id']);
            $price = $product['offer_price'] ?? $product['price'];
            $total += $price * $item['quantity'];
        }
        
        $this->order->customer_id = $customer_id;
        $this->order->total_amount = $total;
        
        $order_id = $this->order->create();
        
        if($order_id) {
            foreach($items as $item) {
                $product = $this->product->getById($item['product_id']);
                $price = $product['offer_price'] ?? $product['price'];
                $this->order->addItem($order_id, $item['product_id'], $item['quantity'], $price);
                
                // Update stock
                $this->product->updateStock($item['product_id'], $item['quantity'], 'stock_out');
            }
            
            return ['success' => true, 'message' => 'Order placed successfully', 'order_id' => $order_id];
        }
        
        return ['success' => false, 'message' => 'Failed to place order'];
    }

    // Wishlist Management
    public function getWishlist($customer_id) {
        return $this->wishlist->getByCustomer($customer_id);
    }

    public function addToWishlist($customer_id, $product_id) {
        if($this->wishlist->add($customer_id, $product_id)) {
            return ['success' => true, 'message' => 'Added to wishlist'];
        }
        return ['success' => false, 'message' => 'Failed to add to wishlist'];
    }

    public function removeFromWishlist($customer_id, $product_id) {
        if($this->wishlist->remove($customer_id, $product_id)) {
            return ['success' => true, 'message' => 'Removed from wishlist'];
        }
        return ['success' => false, 'message' => 'Failed to remove from wishlist'];
    }

    public function isInWishlist($customer_id, $product_id) {
        return $this->wishlist->isInWishlist($customer_id, $product_id);
    }

    // Dashboard Stats
    public function getDashboardStats($customer_id) {
        $orders = $this->order->getByCustomer($customer_id);
        $wishlist = $this->wishlist->getByCustomer($customer_id);
        $products = $this->product->getProductsWithOffers();
        
        $totalSpent = array_reduce($orders, function($carry, $order) {
            return $carry + $order['total_amount'];
        }, 0);
        
        return [
            'total_orders' => count($orders),
            'wishlist_items' => count($wishlist),
            'total_spent' => $totalSpent,
            'offers_available' => count($products)
        ];
    }
}
?>