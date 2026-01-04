<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login($username, $password) {
        $result = $this->user->login($username, $password);
        
        if($result && ! isset($result['error'])) {
            session_start();
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['role'] = $result['role'];
            $_SESSION['full_name'] = $result['full_name'];
            
            return ['success' => true, 'role' => $result['role'], 'message' => 'Login successful'];
        } elseif(isset($result['error'])) {
            return ['success' => false, 'message' => $result['error']];
        }
        
        return ['success' => false, 'message' => 'Invalid username or password'];
    }

    public function register($data) {
        // Check if username exists
        if($this->user->usernameExists($data['username'])) {
            return ['success' => false, 'message' => 'Username already exists'];
        }
        
        // Check if email exists
        if($this->user->emailExists($data['email'])) {
            return ['success' => false, 'message' => 'Email already exists'];
        }
        
        $this->user->username = $data['username'];
        $this->user->email = $data['email'];
        $this->user->password = $data['password'];
        $this->user->full_name = $data['full_name'];
        $this->user->phone = $data['phone'] ?? '';
        $this->user->address = $data['address'] ?? '';
        $this->user->role = $data['role'];
        
        if($this->user->register()) {
            $message = ($data['role'] == 'employee') 
                ? 'Registration successful!  Please wait for admin approval.' 
                : 'Registration successful! You can now login.';
            return ['success' => true, 'message' => $message];
        }
        
        return ['success' => false, 'message' => 'Registration failed'];
    }

    public function logout() {
        session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }

    public function changePassword($user_id, $current_password, $new_password) {
        $user = $this->user->getById($user_id);
        
        if($user && password_verify($current_password, $user['password'])) {
            if($this->user->changePassword($user_id, $new_password)) {
                return ['success' => true, 'message' => 'Password changed successfully'];
            }
        }
        
        return ['success' => false, 'message' => 'Current password is incorrect'];
    }

    public function updateProfile($user_id, $data) {
        $this->user->id = $user_id;
        $this->user->full_name = $data['full_name'];
        $this->user->phone = $data['phone'];
        $this->user->address = $data['address'];
        $this->user->profile_image = $data['profile_image'] ?? 'default.png';
        
        if($this->user->updateProfile()) {
            return ['success' => true, 'message' => 'Profile updated successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to update profile'];
    }

    public function getProfile($user_id) {
        return $this->user->getById($user_id);
    }
}
?>