<?php
/*
Description		: ImageProxy
Source        : http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer     : Clement T (https://github.com/chiunam)
*/

//Initiate parameters
$url = ($_GET['url']) ? $_GET['url'] : '';
$ext = substr($url, -3);

switch ($ext) {
	case 'jpg':
		header('Content-type: image/jpeg');
		break;
	case 'gif':
		header('Content-type: image/gif');
		break;
	case '.js':
		header('Content-type: text/javascript');
		break;
	default:
		header('Content-type: text/plain');
}

if ($fp = fopen($url, 'r')) {
	while ($line = fread($fp, 1024)) {
		echo $line;
	}
}
?>
