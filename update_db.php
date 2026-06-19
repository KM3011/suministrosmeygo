<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host={$host};dbname=meygo_servicios", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Add missing columns
    $conn->exec("ALTER TABLE company_settings ADD COLUMN IF NOT EXISTS company_name VARCHAR(100) DEFAULT 'Servicios Meygo C.A.' AFTER id");
    $conn->exec("ALTER TABLE company_settings ADD COLUMN IF NOT EXISTS company_rif VARCHAR(50) DEFAULT 'J-410220430' AFTER company_name");
    $conn->exec("ALTER TABLE company_settings ADD COLUMN IF NOT EXISTS company_address TEXT AFTER company_rif");
    $conn->exec("ALTER TABLE company_settings ADD COLUMN IF NOT EXISTS company_phone VARCHAR(100) AFTER company_address");
    $conn->exec("ALTER TABLE company_settings ADD COLUMN IF NOT EXISTS payment_info TEXT AFTER company_phone");
    
    $conn->exec("UPDATE company_settings SET company_name = 'Servicios Meygo C.A.' WHERE id = 1");

    echo "Tabla company_settings actualizada en meygo_servicios.";
} catch(PDOException $exception) {
    echo "Error de conexion: " . $exception->getMessage();
}
?>
