<?php
require_once __DIR__ . '/config/database.php';

try {
    // Modify documents table to include new UI fields
    $conn->exec("ALTER TABLE documents ADD COLUMN iva_percentage DECIMAL(5,2) DEFAULT 0 AFTER exchange_rate");
    $conn->exec("ALTER TABLE documents ADD COLUMN subtotal_usd DECIMAL(10,2) DEFAULT 0 AFTER iva_percentage");
    $conn->exec("ALTER TABLE documents ADD COLUMN subtotal_ves DECIMAL(10,2) DEFAULT 0 AFTER subtotal_usd");
    $conn->exec("ALTER TABLE documents ADD COLUMN validity_days INT DEFAULT 30 AFTER subtotal_ves");
    echo "Added new fields to documents table.\n";
} catch (Exception $e) {
    echo "Notice: " . $e->getMessage() . "\n";
}

try {
    // Create document_items table for reprinting capability
    $sql = "CREATE TABLE IF NOT EXISTS document_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        document_id INT NOT NULL,
        description VARCHAR(255) NOT NULL,
        quantity DECIMAL(10,2) NOT NULL,
        unit VARCHAR(50) NOT NULL,
        price_usd DECIMAL(10,2) NOT NULL,
        total_usd DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
    )";
    $conn->exec($sql);
    echo "Table 'document_items' created successfully.\n";
} catch (Exception $e) {
    echo "Error creating document_items: " . $e->getMessage() . "\n";
}
