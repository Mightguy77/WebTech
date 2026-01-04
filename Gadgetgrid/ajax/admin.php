<?php
session_start();
header('Content-Type: application/json');

// Check if user is admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

require_once __DIR__ . '/../controllers/AdminController.php';

$adminController = new AdminController();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    // Employee Management
    case 'get_pending_employees':
        echo json_encode($adminController->getPendingEmployees());
        break;
        
    case 'get_all_employees': 
        echo json_encode($adminController->getAllEmployees());
        break;
        
    case 'approve_employee': 
        $id = $_POST['id'] ?? 0;
        echo json_encode($adminController->approveEmployee($id));
        break;
        
    case 'reject_employee':
        $id = $_POST['id'] ?? 0;
        echo json_encode($adminController->rejectEmployee($id));
        break;
        
    case 'delete_employee':
        $id = $_POST['id'] ?? 0;
        echo json_encode($adminController->deleteEmployee($id));
        break;
        
    // Customer Management
    case 'get_all_customers':
        echo json_encode($adminController->getAllCustomers());
        break;
        
    // Category Management
    case 'get_categories':
        echo json_encode($adminController->getCategories());
        break;
        
    case 'add_category': 
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        echo json_encode($adminController->addCategory($name, $description));
        break;
        
    case 'update_category':
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ??  '';
        echo json_encode($adminController->updateCategory($id, $name, $description));
        break;
        
    case 'delete_category':
        $id = $_POST['id'] ?? 0;
        echo json_encode($adminController->deleteCategory($id));
        break;
        
    // Stock Logs
    case 'get_stock_logs': 
        echo json_encode($adminController->getStockLogs());
        break;
        
    // Dashboard
    case 'get_dashboard_stats': 
        echo json_encode($adminController->getDashboardStats());
        break;
        
    default: 
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>