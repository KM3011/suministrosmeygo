<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host={$host}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create new DB
    $conn->exec("CREATE DATABASE IF NOT EXISTS meygo_servicios");
    $conn->exec("USE meygo_servicios");
    
    // Create tables
    $conn->exec("
    CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Default admin user
    $conn->exec("INSERT INTO admin_users (username, password) VALUES ('admin', 'admin123')");
    
    $conn->exec("
    CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100),
        phone VARCHAR(20),
        address TEXT,
        rif VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $conn->exec("
    CREATE TABLE IF NOT EXISTS company_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        next_factura INT DEFAULT 1,
        next_presupuesto INT DEFAULT 1,
        next_nota INT DEFAULT 1
    )");
    
    // Setup settings if empty
    $conn->exec("INSERT INTO company_settings (next_factura, next_presupuesto, next_nota) VALUES (1, 1, 1)");

    $conn->exec("
    CREATE TABLE IF NOT EXISTS documents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type ENUM('Factura', 'Presupuesto', 'Nota de Entrega') NOT NULL,
        client_name VARCHAR(100) NOT NULL,
        client_id INT NULL,
        date DATE NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        control_number VARCHAR(50),
        currency_mode VARCHAR(20),
        FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL
    )");
    
    echo "Base de datos meygo_servicios creada con exito.";
} catch(PDOException $exception) {
    echo "Error de conexion: " . $exception->getMessage();
}
?>
