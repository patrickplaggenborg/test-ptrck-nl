<?php

if (file_exists('imagettftextblur.php'))
	require_once('imagettftextblur.php');
else
	die('imagettftextblur.php not found');

  // Set Text to Be Printed On Image (fix deprecated filter)
  $text = isset($_GET["street"]) ? htmlspecialchars(strip_tags($_GET["street"]), ENT_QUOTES, 'UTF-8') : '';
  
  if (empty($text)) {
      error_log('Missing street parameter');
      http_response_code(400);
      exit(0);
  }
 
  // Set Image URL with SSRF protection
  $imageurl = isset($_GET["map"]) ? filter_var($_GET["map"], FILTER_VALIDATE_URL) : '';
  
  if (empty($imageurl)) {
      error_log('Missing or invalid map URL parameter');
      http_response_code(400);
      exit(0);
  }

  // SSRF Protection: Whitelist allowed domains
  $allowed_domains = ['maps.googleapis.com', 'api.mapbox.com', 'dl.dropboxusercontent.com'];
  $parsed_url = parse_url($imageurl);
  
  if (!isset($parsed_url['host']) || !in_array($parsed_url['host'], $allowed_domains)) {
      error_log('Blocked SSRF attempt to: ' . ($parsed_url['host'] ?? 'unknown'));
      http_response_code(403);
      exit(0);
  }

  // Block local/private IPs
  $ip = gethostbyname($parsed_url['host']);
  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
      error_log('Blocked internal IP access attempt: ' . $ip);
      http_response_code(403);
      exit(0);
  }

  // Only allow HTTP/HTTPS protocols
  if (!in_array($parsed_url['scheme'], ['http', 'https'])) {
      error_log('Blocked non-HTTP protocol: ' . ($parsed_url['scheme'] ?? 'unknown'));
      http_response_code(403);
      exit(0);
  }

  //Set the Content Type
  header('Content-type: image/jpeg');
  
  // Secure cURL configuration
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $imageurl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 second timeout
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // 5 second connection timeout
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Disable redirects
  curl_setopt($ch, CURLOPT_MAXREDIRS, 0);
  curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS); // Only HTTP/HTTPS
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verify SSL certificates
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Verify hostname
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Some servers block empty user agents
  
  $data = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $curl_error = curl_error($ch);
  curl_close($ch);
  
  if ($data === false || !empty($curl_error)) {
      error_log('cURL error: ' . $curl_error);
      http_response_code(502);
      exit(0);
  }
  
  if ($http_code !== 200) {
      error_log('Invalid HTTP response code: ' . $http_code);
      http_response_code(502);
      exit(0);
  }

    // Validate image data before processing
    if (empty($data) || strlen($data) > 10485760) { // Max 10MB
        error_log('Invalid or oversized image data');
        http_response_code(400);
        exit(0);
    }
    
    $source_image = @imagecreatefromstring($data);
    if ($source_image === false) {
        error_log('Failed to create image from data');
        http_response_code(400);
        exit(0);
    }

	$width  = imagesx($source_image);                             //get width of source image
	$height = imagesy($source_image);                             //get height of source image
	$image = imagecreatetruecolor($width,$height);        //create new image of true colors with given width and height
	imagecopy($image,$source_image,0,0,0,0,$width,$height);      //copy source image to new one


  // Create Image From Existing File
  //  $jpg_image = imagecreatefromjpeg('sunset.jpg');


  // Allocate A Color For The Text
  $blur_color = imagecolorallocate($image, 255, 255, 255);
  $font_color = imagecolorallocate($image, 107, 33, 42);


  // Set Path to Font File
  $font_path = 'Roboto-Medium.ttf';

  // Print Text On Image
//  imagettftext($image, 20, 0, 663, 363, $font_color, $font_path, $text);
  imagettftextblur($image, 20, 0, 663, 363, $blur_color, $font_path, $text,5);
  imagettftextblur($image, 20, 0, 663, 363, $font_color, $font_path, $text);


  // Send Image to Browser
  imagejpeg($image,NULL,100);

  // Clear Memory
  imagedestroy($image);
  
  
  
  
?>