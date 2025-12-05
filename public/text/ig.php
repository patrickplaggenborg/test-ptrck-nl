<?php

$handle = fopen('http://test.ptrck.nl/text/example.jpg', 'rb');
$img = new Imagick();
$img->readImageFile($handle);
$img->resizeImage(128, 128, 0, 0);
$img->writeImage('foo.jpg');


?>