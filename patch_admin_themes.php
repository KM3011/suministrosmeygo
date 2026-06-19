<?php
$dir = 'c:/xampp/htdocs/suministrosmg/admin/';
$files = ['index.php', 'clients.php', 'create_document.php', 'documents_registry.php', 'finances.php', 'receivables.php', 'settings.php', 'users.php'];

foreach ($files as $file) {
    $path = $dir . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        if (strpos($content, '$theme_class =') === false) {
            $content = preg_replace("/\\?>\\s*<!DOCTYPE html>/", "\$theme_class = (isset(\$_SESSION['company_context']) && \$_SESSION['company_context'] == 'servicios') ? 'theme-servicios' : 'theme-suministros';\n?>\n<!DOCTYPE html>", $content);
        }
        
        if (strpos($content, '<body class="') === false) {
            $content = preg_replace('/<body>/', '<body class="<?php echo $theme_class; ?>">', $content);
        }
        
        $content = preg_replace('/class="main-content" style="background: linear-gradient[^"]*"/', 'class="main-content"', $content);
        
        file_put_contents($path, $content);
        echo "Updated $file\n";
    }
}
?>
