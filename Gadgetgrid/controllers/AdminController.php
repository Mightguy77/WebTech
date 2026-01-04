<?php
require_once __DIR__ . '/../config/database. php';
require_once __DIR__ .  '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/StockLog.php';
require_once __DIR__ . '/../models/Product.php';

class AdminController {
    private $db;
    private $user;
    private $category;
    private $stockLog;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->category = new Category($this->db);
        $this->stockLog = new StockLog($this->db);
        $this->product = new Product($this->db);
    }

    // Employee Management
    public function getPendingEmployees() {
        return $this->user->getPendingEmployees();
    }

    public function getAllEmployees() {
        return $this->user->getAllByRole('employee');
    }

    public function approveEmployee($id) {
        if($this->user->updateStatus($id, 'approved')) {
            return ['success' => true, 'message' => 'Employee approved successfully'];
        }
        return ['success' => false, 'message' => 'Failed to approve employee'];
    }

    public function rejectEmployee($id) {
        if($this->user->updateStatus($id, 'rejected')) {
            return ['success' => true, 'message' => 'Employee rejected'];
        }
        return ['success' => false, 'message' => 'Failed to reject employee'];
    }

    public function deleteEmployee($id) {
        if($this->user->delete($id)) {
            return ['success' => true, 'message' => 'Employee deleted successfully'];
        }
        return ['success' => false, 'message' => 'Failed to delete employee'];
    }

    // Customer Management
    public function getAllCustomers() {
        return $this->user->getAllByRole('customer');
    }

    // Category Management
    public function getCategories() {
        return $this->category->getAllWithProductCount();
    }

    public function addCategory($name, $description) {
        $this->category->name = $name;
        $this->category->description = $description;
        
        if($this->category->create()) {
            return ['success' => true, 'message' => 'Category added successfully'];
        }
        return ['success' => false, 'message' => 'Failed to add category'];
    }

    public function updateCategory($id, $name, $description) {
        $this->category->id = $id;
        $this->category->name = $name;
        $this->category->description = $description;
        
        if($this->category->update()) {
            return ['success' => true, 'message' => 'Category updated successfully'];
        }
        return ['success' => false, 'message' => 'Failed to update category'];
    }

    public function deleteCategory($id) {
        if($this->category->delete($id)) {
            return ['success' => true, 'message' => 'Category deleted successfully'];
        }
        return ['success' => false, 'message' => 'Failed to delete category'];
    }

    // Stock Logs
    public function getStockLogs() {
        return $this->stockLog->getAll();
    }

    // Dashboard Stats
    public function getDashboardStats() {
        $employees = $this->user->getAllByRole('employee');
        $customers = $this->user->getAllByRole('customer');
        $categories = $this->category->getAll();
        $products = $this->product->getAll();
        $pendingEmployees = $this->user->getPendingEmployees();
        
        return [
            'total_employees' => count($employees),
            'total_customers' => count($customers),
            'total_categories' => count($categories),
            'total_products' => count($products),
            'pending_approvals' => count($pendingEmployees)
        ];
    }
}
?>