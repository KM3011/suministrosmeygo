<?php
$sourceFile = __DIR__ . '/assets/images/logo.png';
$outputFile = __DIR__ . '/assets/images/logo_pdf.jpg';

// Try to create an image from the source file, handling different possible actual types
$image = @imagecreatefrompng($sourceFile);
if (!$image) {
    $image = @imagecreatefromjpeg($sourceFile);
}
if (!$image) {
    $image = @imagecreatefromwebp($sourceFile);
}

if ($image) {
    // Create a white background canvas (since JPEGs don't support transparency)
    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    $white = imagecolorallocate($bg, 255, 255, 255);
    imagefill($bg, 0, 0, $white);
    
    // Copy the original image over the white background
    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    
    // Save as JPEG
    imagejpeg($bg, $outputFile, 90);
    
    imagedestroy($image);
    imagedestroy($bg);
    echo "Image successfully converted to logo_pdf.jpg\n";
} else {
    echo "Failed to process logo.png. It might not be a valid image file.\n";
}
