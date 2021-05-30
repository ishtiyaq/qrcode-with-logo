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
$qr = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));

if($logo !== FALSE) {
	$logo = imagecreatefromstring(file_get_contents($logo));

	$qr_width = imagesx($qr);
	$qr_height = imagesy($qr);
	
	$logo_width = imagesx($logo);
	$logo_height = imagesy($logo);
	
	// Scale logo to fit in the QR Code
	$logo_qr_width = $qr_width/3;
	$scale = $logo_width/$logo_qr_width;
	$logo_qr_height = $logo_height/$scale;
	
	imagecopyresampled($qr, $logo, $qr_width/3, $qr_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}

imagepng($qr);
imagedestroy($qr);
