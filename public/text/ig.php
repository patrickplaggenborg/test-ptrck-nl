<?php
// Security: Use HTTPS and validate image before processing
// Note: This script uses ImageMagick which has known vulnerabilities
// Consider disabling ImageMagick or using GD library instead

if (!extension_loaded('imagick')) {
    error_log('ImageMagick extension not available');
    http_response_code(503);
    exit(0);
}

// Use HTTPS to prevent MITM attacks
$image_url = 'https://test.ptrck.nl/text/example.jpg';

// Validate URL
if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
    error_log('Invalid image URL');
    http_response_code(400);
    exit(0);
}

$handle = @fopen($image_url, 'rb');
if ($handle === false) {
    error_log('Failed to open image URL');
    http_response_code(502);
    exit(0);
}

try {
    $img = new Imagick();
    
    // Set resource limits to prevent DoS
    $img->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 128);
    $img->setResourceLimit(Imagick::RESOURCETYPE_MAP, 256);
    $img->setResourceLimit(Imagick::RESOURCETYPE_TIME, 10);
    
    $img->readImageFile($handle);
    fclose($handle);
    
    // Validate image format
    $format = $img->getImageFormat();
    $allowed_formats = ['JPEG', 'PNG', 'GIF', 'WEBP'];
    if (!in_array($format, $allowed_formats)) {
        error_log('Invalid image format: ' . $format);
        $img->destroy();
        http_response_code(400);
        exit(0);
    }
    
    // Validate image dimensions
    $width = $img->getImageWidth();
    $height = $img->getImageHeight();
    if ($width > 10000 || $height > 10000) {
        error_log('Image dimensions too large');
        $img->destroy();
        http_response_code(400);
        exit(0);
    }
    
    $img->resizeImage(128, 128, Imagick::FILTER_LANCZOS, 1);
    
    // Use secure output path (not writable by web server in production)
    $output_path = sys_get_temp_dir() . '/resized_' . uniqid() . '.jpg';
    $img->writeImage($output_path);
    $img->destroy();
    
    // In production, you might want to serve this file or delete it
    // For now, just clean up
    @unlink($output_path);
    
} catch (ImagickException $e) {
    error_log('ImageMagick error: ' . $e->getMessage());
    if (isset($handle) && is_resource($handle)) {
        fclose($handle);
    }
    if (isset($img)) {
        $img->destroy();
    }
    http_response_code(500);
    exit(0);
}

?>