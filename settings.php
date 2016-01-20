<?
/*
Description		: iNext Setting Stylesheet
Source			: http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer		: Clement T (http://chiunam.net)
Version			: 2.0.0
Create Date		: 2009-05-19
Last Update		: 2012-05-11
*/

require('config.php');
date_default_timezone_set('Asia/Hong_Kong');

$fontsize		= ($_COOKIE['fontsize']) ? ($_COOKIE['fontsize']) : "2";
$lastmodified	= ($_COOKIE['last-modified']) ? ($_COOKIE['last-modified']) : time();

if ($lastmodified <= strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
	header("HTTP/1.0 304 Not Modified");
	exit;	
}

header("Content-type: text/css");
header("Last-Modified: " . gmdate('D, d M Y H:i:s', $lastmodified) . " GMT");	
header("Cache-Control: no-cache, must-revalidate");

?>

/*
header:			<?php echo strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])?>

last-modified: 	<?php echo $lastmodified?>
*/

.content{
	font-size:<?php echo $fontsize?>em;
}
.list > li, .list > li.group, .list > li.subgroup{
	font-size:<?php echo ($fontsize=="1.6") ? $fontsize : ($fontsize / 1.25)?>em;
}
