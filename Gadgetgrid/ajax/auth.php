<?php
session_start();
header('Content-Type:  application/json');

require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();
$action = $_POST['action'] ?? $_GET['action'] ??  '';

switch($action) {
    case 'login':
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        echo json_encode($authController->login($username, $password));
        break;
        
    case 'register':
        $data = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ??  '',
            'role' => $_POST['role'] ?? 'customer'
        ];
        echo json_encode($authController->register($data));
        break;
        
    case 'logout':
        echo json_encode($authController->logout());
        break;
        
    case 'change_password':
        $user_id = $_SESSION['user_id'] ?? 0;
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        echo json_encode($authController->changePassword($user_id, $current_password, $new_password));
        break;
        
    case 'update_profile':
        $user_id = $_SESSION['user_id'] ?? 0;
        $data = [
            'full_name' => $_POST['full_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ?? '',
            'profile_image' => $_POST['profile_image'] ?? 'default. png'
        ];
        echo json_encode($authController->updateProfile($user_id, $data));
        break;
        
    case 'get_profile':
        $user_id = $_SESSION['user_id'] ?? 0;
        echo json_encode($authController->getProfile($user_id));
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>