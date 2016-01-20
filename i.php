<?
/*
Description		: ImageProxy
Source			: http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer		: Clement T (http://chiunam.net)
Version			: 2.0.0
Create Date		: 2010-06-23
Last Update		: 2012-05-11
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
