<?php
session_start();
header('Content-Type: application/json');

// Check if user is employee
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

require_once __DIR__ . '/../controllers/EmployeeController.php';

$employeeController = new EmployeeController();
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$employee_id = $_SESSION['user_id'];

