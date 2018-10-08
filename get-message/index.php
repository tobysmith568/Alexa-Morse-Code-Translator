<?php

if (!isset($_GET['text'])) {
    header("HTTP/1.0 404 Not Found");
	die();
}

$soundFolder = '../codes/';
$extension = '.mp3';

$fileNames = [
	' ' => '_Gap',
	'a' => 'A',
	'b' => 'B',
	'c' => 'C',
	'd' => 'D',
	'e' => 'E',
	'f' => 'F',
	'g' => 'G',
	'h' => 'H',
	'i' => 'I',
	'j' => 'J',
	'k' => 'K',
	'l' => 'L',
	'm' => 'M',
	'n' => 'N',
	'o' => 'O',
	'p' => 'P',
	'q' => 'Q',
	'r' => 'R',
	's' => 'S',
	't' => 'T',
	'u' => 'U',
	'v' => 'V',
	'w' => 'W',
	'x' => 'X',
	'y' => 'Y',
	'z' => 'Z',
	'1' => '1',
	'2' => '2',
	'3' => '3',
	'4' => '4',
	'5' => '5',
	'6' => '6',
	'7' => '7',
	'8' => '8',
	'9' => '9',
	'0' => '0'
];

ob_start();

$total = 0;
$array = str_split($_GET['text']);
foreach ($array as $char) {
	if (isset($fileNames[$char])) {
		$file = "$soundFolder$fileNames[$char]$extension";
		readfile($file);
		$total = ($total + filesize($file));
	}
	else if ($char === ' ') {
	}
}

$result = ob_get_contents(); 

header('Cache-Control: no-cache');
header('Content-type: audio/mpeg');
header("Content-length: $total");

echo $result;






















