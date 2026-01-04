-- GadgetGrid Database Schema
-- Import this file into XAMPP phpMyAdmin

CREATE DATABASE IF NOT EXISTS gadgetgrid;
USE gadgetgrid;

-- Users Table (Admin, Employee, Customer)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'employee', 'customer') NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved',
    profile_image VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    specifications TEXT,
    price DECIMAL(10, 2) NOT NULL,
    offer_price DECIMAL(10, 2) DEFAULT NULL,
    offer_percentage INT DEFAULT 0,
    stock_quantity INT DEFAULT 0,
    image VARCHAR(255) DEFAULT 'default_product.png',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Stock Logs Table
CREATE TABLE stock_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    employee_id INT,
    action_type ENUM('stock_in', 'stock_out') NOT NULL,
    quantity INT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Orders Table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Wishlist Table
CREATE TABLE wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    product_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (customer_id, product_id)
);

-- Insert Default Admin
INSERT INTO users (username, email, password, full_name, role, status) 
VALUES ('admin', 'admin@gadgetgrid.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/. og/at2.uheWG/igi', 'System Administrator', 'admin', 'approved');
-- Default password: password

-- Insert Sample Categories
INSERT INTO categories (name, description) VALUES 
('Mobiles', 'Smartphones and mobile devices'),
('Watches', 'Smart watches and fitness trackers'),
('Earbuds', 'Wireless earbuds and headphones'),
('VR Headsets', 'Virtual reality headsets and accessories'),
('Accessories', 'Mobile and tech accessories');

-- Insert Sample Products
INSERT INTO products (category_id, name, description, specifications, price, stock_quantity, created_by) VALUES 
(1, 'iPhone 15 Pro', 'Latest Apple smartphone with A17 chip', '6.1" Display, 256GB Storage, 48MP Camera', 999. 99, 50, 1),
(1, 'Samsung Galaxy S24', 'Flagship Android smartphone', '6.2" Dynamic AMOLED, 128GB, 50MP Camera', 849.99, 35, 1),
(2, 'Apple Watch Series 9', 'Advanced health and fitness smartwatch', 'GPS, 41mm, Always-On Retina display', 399.99, 25, 1),
(2, 'Samsung Galaxy Watch 6', 'Premium Android smartwatch', '44mm, Super AMOLED, Health monitoring', 329.99, 30, 1),
(3, 'AirPods Pro 2', 'Premium wireless earbuds with ANC', 'Active Noise Cancellation, Spatial Audio', 249.99, 60, 1),
(3, 'Samsung Galaxy Buds 2 Pro', 'Hi-Fi wireless earbuds', '24-bit Hi-Fi, ANC, 360 Audio', 199.99, 45, 1),
(4, 'Meta Quest 3', 'Mixed reality VR headset', '128GB, Mixed Reality, Hand Tracking', 499.99, 20, 1),
(5, 'Anker PowerCore 20000', 'High-capacity portable charger', '20000mAh, USB-C, Fast Charging', 49.99, 100, 1);