<?php

if (file_exists('imagettftextblur.php'))
	require_once('imagettftextblur.php');
else
	die('imagettftextblur.php not found');

  // Set Text to Be Printed On Image
  $text = isset($_GET["street"]) ? filter_var($_GET["street"], FILTER_SANITIZE_STRING) : '';
  
  if (empty($text)) {
      error_log('Missing street parameter');
      http_response_code(400);
      exit(0);
  }
 
  // Set Image URL
  $imageurl = isset($_GET["map"]) ? filter_var($_GET["map"], FILTER_VALIDATE_URL) : '';
  
  if (empty($imageurl)) {
      error_log('Missing or invalid map URL parameter');
      http_response_code(400);
      exit(0);
  }

  // Remove debug die() statement

  //Set the Content Type
  header('Content-type: image/jpeg');
  

  
  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $imageurl); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // good edit, thanks!
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // also, this seems wise considering output is image.
    $data = curl_exec($ch);
    curl_close($ch);

    $source_image = imagecreatefromstring($data);

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