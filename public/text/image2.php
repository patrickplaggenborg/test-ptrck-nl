<?php

if (file_exists('imagettftextblur.php'))
	require_once('imagettftextblur.php');
else
	die('imagettftextblur.php not found');


  
  // Set Text to Be Printed On Image
  $text = "Bosdammen 2";

  
  // Set Image URL (updated to HTTPS)
  $imageurl = "https://maps.googleapis.com/maps/api/staticmap?zoom=17&scale=2&size=640x360&maptype=roadmap&format=png&visual_refresh=false&markers=scale:2|icon:https://dl.dropboxusercontent.com/u/691052/icon/marker_googlemaps_75.png%7Cshadow:true%7CBosdammen+2,+Ammerzoden";
  
  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $imageurl); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // good edit, thanks!
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // also, this seems wise considering output is image.
    $data = curl_exec($ch);
    curl_close($ch);

    $image = imagecreatefromstring($data);


    echo 'typeof($image) = ' . (imageistruecolor($image) ? 'true color' : 'palette'), PHP_EOL;



  // Create Image From Existing File
  //  $jpg_image = imagecreatefromjpeg('sunset.jpg');


  // Allocate A Color For The Text
  $blur_color = imagecolorallocate($image, 255, 255, 255);
  $font_color = imagecolorallocate($image, 107, 33, 42);


  // Set Path to Font File
  $font_path = 'Roboto-Medium.ttf';

  // Print Text On Image
//  imagettftext($image, 20, 0, 663, 363, $font_color, $font_path, $text);
//  imagettftextblur($image, 20, 0, 663, 363, $blur_color, $font_path, $text,20);
  imagettftextblur($image, 20, 0, 663, 363, $font_color, $font_path, $text);


  // Send Image to Browser
//  imagejpeg($image,NULL,100);
//  imagepng($image);

  // Clear Memory
  imagedestroy($image);
  
  
  
  
?>