<?php
require('fpdf/fpdf.php');

// Enable error reporting for debug (disable in prod)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Get JSON POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'No data received']);
    exit;
}

$name = $data['name'] ?? 'Cliente General';
$rif = $data['rif'] ?? 'N/A';
$phone = $data['phone'] ?? 'N/A';
$email = $data['email'] ?? 'N/A';
$details = $data['details'] ?? '';

// Basic PDF generation
class FrontendQuotePDF extends FPDF {
    function Header() {
        if (file_exists('assets/images/logo.jpg')) {
            $this->Image('assets/images/logo.jpg', 10, 8, 40);
        } else if (file_exists('assets/images/logo.png')) {
            $this->Image('assets/images/logo.png', 10, 8, 40);
        }
        
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(30, 75, 130);
        $this->SetXY(55, 12);
        $this->Cell(80, 6, utf8_decode('MEYGO - SOLICITUD DE COTIZACIÓN'), 0, 1, 'L');
        
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(51, 51, 51);
        $this->SetXY(55, 18);
        $this->Cell(80, 5, utf8_decode('Generado desde el portal web'), 0, 1, 'L');
        $this->SetX(55);
        $this->Cell(80, 5, utf8_decode('Fecha: ' . date('d/m/Y H:i:s')), 0, 1, 'L');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, utf8_decode('Documento pre-generado por el sistema Meygo ERP'), 0, 0, 'C');
    }
}

try {
    $pdf = new FrontendQuotePDF();
    $pdf->AddPage();
    
    $pdf->Ln(20);

    // Client Info Box
    $pdf->SetFillColor(232, 241, 255);
    $pdf->SetDrawColor(160, 188, 224);
    $pdf->Rect(10, $pdf->GetY(), 190, 30, 'DF');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(30, 75, 130);
    $pdf->SetXY(12, $pdf->GetY() + 2);
    $pdf->Cell(186, 6, utf8_decode(' DATOS DEL CLIENTE / SOLICITANTE'), 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(51, 51, 51);
    $pdf->SetX(12);
    $pdf->Cell(20, 5, utf8_decode('Nombre:'), 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(100, 5, utf8_decode($name), 0, 0);
    
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(15, 5, utf8_decode('RIF/C.I:'), 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(45, 5, utf8_decode($rif), 0, 1);

    $pdf->SetX(12);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 5, utf8_decode('Teléfono:'), 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(100, 5, utf8_decode($phone), 0, 0);
    
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(15, 5, utf8_decode('Correo:'), 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(45, 5, utf8_decode($email), 0, 1);

    $pdf->Ln(15);
    
    // Request Details
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(30, 75, 130);
    $pdf->Cell(0, 6, utf8_decode('DETALLE DEL REQUERIMIENTO'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(51, 51, 51);
    
    $pdf->MultiCell(0, 6, utf8_decode($details), 1, 'L');

    // Generate File
    $filename = 'cotizacion_' . time() . '_' . rand(1000, 9999) . '.pdf';
    $filepath = 'assets/quotes/' . $filename;
    
    $pdf->Output('F', $filepath);
    
    // Construct full URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    // Try to determine the base path (assuming this script is in the root)
    $script_path = dirname($_SERVER['SCRIPT_NAME']);
    $url = $protocol . $host . $script_path . '/' . $filepath;

    echo json_encode([
        'success' => true,
        'url' => $url,
        'filepath' => $filepath
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
