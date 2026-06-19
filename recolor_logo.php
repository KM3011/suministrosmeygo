<?php
function recolorLogo($srcFile, $destFile, $isJpeg) {
    if (!file_exists($srcFile)) {
        echo "Missing $srcFile\n";
        return;
    }
    
    if ($isJpeg) {
        $im = imagecreatefromjpeg($srcFile);
    } else {
        $im = imagecreatefrompng($srcFile);
        imagealphablending($im, false);
        imagesavealpha($im, true);
    }

    $w = imagesx($im);
    $h = imagesy($im);

    for($x = 0; $x < $w; $x++) {
        for($y = 0; $y < $h; $y++) {
            $rgb = imagecolorat($im, $x, $y);
            $colors = imagecolorsforindex($im, $rgb);
            
            $r = $colors['red'];
            $g = $colors['green'];
            $b = $colors['blue'];
            $a = isset($colors['alpha']) ? $colors['alpha'] : 0;
            
            // Check if pixel is predominantly blue
            if ($b > $r && $b > $g) {
                // Map blue to orange
                $newR = $b; // Blue becomes Red
                $newG = min(255, intval($b * 0.55)); // Green is roughly half of Red for orange
                $newB = $r; // Red becomes Blue
                
                if ($isJpeg) {
                    $newColor = imagecolorallocate($im, $newR, $newG, $newB);
                } else {
                    $newColor = imagecolorallocatealpha($im, $newR, $newG, $newB, $a);
                }
                imagesetpixel($im, $x, $y, $newColor);
            }
        }
    }
    
    if ($isJpeg) {
        imagejpeg($im, $destFile, 100);
    } else {
        imagepng($im, $destFile);
    }
    imagedestroy($im);
    echo "Generated $destFile\n";
}

recolorLogo('assets/images/logo.png', 'assets/images/logo-servicios.png', false);
recolorLogo('assets/images/logo.jpg', 'assets/images/logo-servicios.jpg', true);
?>
