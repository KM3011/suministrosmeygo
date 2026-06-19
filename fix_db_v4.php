<?php
require_once __DIR__ . '/config/database.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS company_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_name VARCHAR(100) NOT NULL,
        company_rif VARCHAR(50) NOT NULL,
        company_address TEXT NOT NULL,
        company_phone VARCHAR(100) NOT NULL,
        payment_info TEXT NOT NULL
    )";
    $conn->exec($sql);
    
    // Check if empty, then insert default
    $stmt = $conn->query("SELECT count(*) FROM company_settings");
    if ($stmt->fetchColumn() == 0) {
        $default_payment = "CUENTA CORRIENTE BANCAMIGA Nº 01720110791109143634\n" .
                           "A NOMBRE DE SUMINISTROS MEYGO RIF J-410220430\n" .
                           "TASA BCV DEL DIA";
                           
        $insert = $conn->prepare("INSERT INTO company_settings (company_name, company_rif, company_address, company_phone, payment_info) VALUES (?, ?, ?, ?, ?)");
        $insert->execute([
            'SUMINISTROS MEYGO C.A.',
            'J-410220430',
            'Maracay, Edo Aragua, Venezuela',
            'Tel: +58 414 7327301 | suministrosmeygo@hotmail.com',
            $default_payment
        ]);
        echo "Default company settings inserted.\n";
    } else {
        echo "Company settings table already exists and has data.\n";
    }
} catch (Exception $e) {
    echo "Error creating company_settings: " . $e->getMessage() . "\n";
}
