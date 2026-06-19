<?php
$files = glob('admin/*.php');
$bad_string = "<?php \$logo_img = (isset(\$_SESSION['company_context']) && \$_SESSION['company_context'] == 'servicios') ? 'logo-servicios.png' : 'logo.png'; ?>\n        <img src=\"../assets/images/<?php echo \$logo_img; ?>\" alt=\"Meygo Logo\" class=\"sidebar-logo\">";
$good_string = "<img src=\"../assets/images/logo.png\" alt=\"Meygo Logo\" class=\"sidebar-logo\">";

foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, $bad_string) !== false) {
        $content = str_replace($bad_string, $good_string, $content);
        file_put_contents($file, $content);
        echo "Fixed $file\n";
    }
}
?>
