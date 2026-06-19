<?php
require_once __DIR__ . '/config/database.php';

try {
    $conn->exec("ALTER TABLE company_settings ADD COLUMN next_factura INT DEFAULT 1");
    $conn->exec("ALTER TABLE company_settings ADD COLUMN next_presupuesto INT DEFAULT 1");
    $conn->exec("ALTER TABLE company_settings ADD COLUMN next_nota INT DEFAULT 1");
    echo "Columns added successfully.\n";
} catch (Exception $e) {
    echo "Error adding columns: " . $e->getMessage() . "\n";
}
