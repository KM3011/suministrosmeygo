<?php
require_once __DIR__ . '/config/database.php';

try {
    // Add columns if they don't exist
    $conn->exec("ALTER TABLE documents ADD COLUMN document_type ENUM('Factura', 'Presupuesto', 'Nota de Entrega') NOT NULL DEFAULT 'Factura'");
    $conn->exec("ALTER TABLE documents ADD COLUMN client_name VARCHAR(150) NOT NULL DEFAULT 'Cliente'");
    $conn->exec("ALTER TABLE documents ADD COLUMN currency_mode ENUM('USD', 'VES', 'MIXTO') NOT NULL DEFAULT 'USD'");
    $conn->exec("ALTER TABLE documents ADD COLUMN exchange_rate DECIMAL(10,2) DEFAULT 0");
    $conn->exec("ALTER TABLE documents ADD COLUMN total_usd DECIMAL(10,2) DEFAULT 0");
    $conn->exec("ALTER TABLE documents ADD COLUMN total_ves DECIMAL(10,2) DEFAULT 0");
    $conn->exec("ALTER TABLE documents ADD COLUMN status ENUM('Pendiente', 'Pagado') DEFAULT 'Pendiente'");
    echo "Columns added to documents table successfully.\n";
} catch (PDOException $e) {
    echo "Error adding columns (they might already exist): " . $e->getMessage() . "\n";
}

try {
    // Also create financial_records just in case
    $sqlFinancial = "CREATE TABLE IF NOT EXISTS financial_records (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type ENUM('Ingreso', 'Egreso') NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        currency ENUM('USD', 'VES') NOT NULL,
        payment_method ENUM('Banco', 'Efectivo', 'Binance') NOT NULL,
        description VARCHAR(255) NOT NULL,
        document_id INT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sqlFinancial);
    echo "Table 'financial_records' checked/created.\n";

} catch (PDOException $e) {
    echo "Error with financial_records: " . $e->getMessage() . "\n";
}
