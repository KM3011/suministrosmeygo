<?php
require_once __DIR__ . '/config/database.php';

try {
    // Drop table to recreate it cleanly with all new columns
    $conn->exec("DROP TABLE IF EXISTS documents");
    
    // Create documents table
    $sqlDocuments = "CREATE TABLE documents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        document_type ENUM('Factura', 'Presupuesto', 'Nota de Entrega') NOT NULL,
        client_name VARCHAR(150) NOT NULL,
        currency_mode ENUM('USD', 'VES', 'MIXTO') NOT NULL,
        exchange_rate DECIMAL(10,2) DEFAULT 0,
        total_usd DECIMAL(10,2) DEFAULT 0,
        total_ves DECIMAL(10,2) DEFAULT 0,
        status ENUM('Pendiente', 'Pagado') DEFAULT 'Pendiente',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sqlDocuments);
    echo "Table 'documents' recreated successfully with all new columns.\n";

} catch (PDOException $e) {
    echo "Error recreating table: " . $e->getMessage() . "\n";
}
