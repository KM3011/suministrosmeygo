<?php
$files = glob(__DIR__ . '/admin/*.php');

$replacements = [
    'Configuración' => 'Configuracion', 'configuración' => 'configuracion',
    'Administración' => 'Administracion', 'administración' => 'administracion',
    'Teléfono' => 'Telefono', 'teléfono' => 'telefono',
    'Dirección' => 'Direccion', 'dirección' => 'direccion',
    'Facturación' => 'Facturacion', 'facturación' => 'facturacion',
    'Bolívares' => 'Bolivares', 'bolívares' => 'bolivares',
    'Dólares' => 'Dolares', 'dólares' => 'dolares',
    'Dólar' => 'Dolar', 'dólar' => 'dolar',
    'Días' => 'Dias', 'días' => 'dias',
    'Cédula' => 'Cedula', 'cédula' => 'cedula',
    'Emisión' => 'Emision', 'emisión' => 'emision',
    'Acción' => 'Accion', 'acción' => 'accion',
    'Descripción' => 'Descripcion', 'descripción' => 'descripcion',
    'Más' => 'Mas', 'más' => 'mas',
    'Añadir' => 'Anadir', 'añadir' => 'anadir',
    'Éxito' => 'Exito', 'éxito' => 'exito',
    'Inversión' => 'Inversion', 'inversión' => 'inversion',
    'Información' => 'Informacion', 'información' => 'informacion',
    'Número' => 'Numero', 'número' => 'numero',
    'Rápido' => 'Rapido', 'rápido' => 'rapido',
    'Términos' => 'Terminos', 'términos' => 'terminos',
    'Estadísticas' => 'Estadisticas', 'estadísticas' => 'estadisticas',
    'Últimos' => 'Ultimos', 'últimos' => 'ultimos',
    'Módulo' => 'Modulo', 'módulo' => 'modulo'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    file_put_contents($file, $content);
}
echo "Accents removed successfully.\n";
?>
