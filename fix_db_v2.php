<?php
require_once __DIR__ . '/config/database.php';

try {
    $conn->exec("ALTER TABLE clients ADD COLUMN rif VARCHAR(50) DEFAULT 'N/A' AFTER name");
    echo "Added 'rif' to clients.\n";
} catch (Exception $e) {
    echo "Column 'rif' might already exist: " . $e->getMessage() . "\n";
}

try {
    $conn->exec("ALTER TABLE documents ADD COLUMN control_number VARCHAR(50) DEFAULT '0000/0000' AFTER id");
    echo "Added 'control_number' to documents.\n";
} catch (Exception $e) {
    echo "Column 'control_number' might already exist: " . $e->getMessage() . "\n";
}
