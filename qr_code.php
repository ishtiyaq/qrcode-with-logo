<?php
/**
 * QR Code Generator with Custom Logo
 *
 * http://lessons4you.info
 */

$data = isset($_GET['data']) ? $_GET['data'] : 'https://lessons4you.info';
$size = isset($_GET['size']) ? $_GET['size'] : '250x250';
$logo = isset($_GET['logo']) ? $_GET['logo'] : FALSE;

header('Content-type: image/png');

// Get QR Code image from Google Chart API
// http://code.google.com/apis/chart/infographics/docs/qr_codes.html
$QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));

if($logo !== FALSE) {
	$logo = imagecreatefromstring(file_get_contents($logo));

	$QR_width = imagesx($QR);
	$QR_height = imagesy($QR);
	
	$logo_width = imagesx($logo);
	$logo_height = imagesy($logo);
	
	// Scale logo to fit in the QR Code
	$logo_qr_width = $QR_width/3;
	$scale = $logo_width/$logo_qr_width;
	$logo_qr_height = $logo_height/$scale;
	
	imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}

imagepng($QR);
imagedestroy($QR);
