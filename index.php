<?
/*
Description		: iNext
Source			: http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer		: Clement T (http://chiunam.net)
Version			: 2.0.0
Create Date		: 2009-05-19
Last Update		: 2016-01-09
*/


require('config.php');
require('header.php');

//Save Setting
if ($_POST['settingSubmit']==true)
{
	//save font size
	setcookie("fontsize", $_POST['fontsize'], time()+60*60*24*30, ROOT);
	setcookie("last-modified", time(), time()+60*60*24*30, ROOT);

	if ($_POST['cache'] == on) {
		setcookie("cache-since", time(), time()+60*60*24*30, ROOT);
	}
	header("Location: .");
}

//Init cookies
if (!$_COOKIE['fontsize'])
{
	setcookie("fontsize", "2", time()+60*60*24*30, ROOT);
	setcookie("last-modified", time(), time()+60*60*24*30, ROOT);
}

$fontsize = ($_COOKIE['fontsize']) ? ($_COOKIE['fontsize']) : "2";

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>iNext</title>
	<?php
	echo VIEWPORT;
	echo ICON;
	?>
	<link href="<?php echo ROOT.CSS?>?<?php echo VERSION?>" rel="stylesheet" type="text/css" media="screen">
	<?php if (MOD_REWRITE) {?>
	<link href="<?php echo ROOT?>css/settings/" rel="stylesheet" type="text/css" media="screen">
	<?php } else {?>
	<link href="<?php echo ROOT?>settings.php" rel="stylesheet" type="text/css" media="screen">
	<?php }?>

	<script src="<?php echo ROOT?>js/stay_standalone.js" type="text/javascript"></script>
	<style type="text/css" media="screen">
		.list a:visited { color:#000 !important; }
	</style>
</head>
<body id="index">
	<?php
	if (!$_GET['settings']) {
	?>
	    <div id="page">
			<header>
				<p>iNext</p>
				<a class="button" id="settingButton" href="?settings=1">Settings</a>
			</header>
	        <ul class="list">
			<?php
			foreach ($nextproxy as $id => $next) {
                if (MOD_REWRITE) {
					?><li><a href="<?php echo ROOT.$id.'/'?>"><?php echo $next["name"]?></a></li><?php
				} else {
					?><li><a href="proxy.php?next_id=<?php echo $id?>"><?php echo $next["name"]?></a></li><?php
				}
			}
			?>
	        </ul>
	    </div>
	<?php
	}
	?>

	<?php
	if ($_GET['settings']) {
	?>
	    <div id="page">
			<header>
				<p>iNext</p>
				<a class="button" href="javascript:;" onclick="document.getElementById('settingForm').submit();">Done</a>
			</header>
			<div class="panel">
				<form action="." method="post" id="settingForm">
				<input type="hidden" name="settingSubmit" value="ture">
		        <?php/*<fieldset>
		            <div class="row">
		                <label>Auth. Code</label>
						<input type="password" name="authcode" value="<?php echo $authcode?>">
						</select>
		            </div>
		        </fieldset>*/?>
		        <fieldset>
		            <div class="row">
		                <label>Font Size</label>
						<select name="fontsize">
		                <option value="1.6"<?php if ($fontsize=='1.6') echo ' selected'?>>Small</option>
						<option value="2"<?php if ($fontsize=='2') echo ' selected'?>>Medium</option>
						<option value="2.5"<?php if ($fontsize=='2.5') echo ' selected'?>>Large</option>
						<option value="3"<?php if ($fontsize=='3') echo ' selected'?>>Extra Large</option>
						</select>
		            </div>
		        </fieldset>

		        <?php/*<fieldset>
		            <div class="row">
		                <label>Check to Clear Cache</label>
		                <input type="checkbox" name="cache" />
		            </div>
		        </fieldset>*/?>


				</form>
			</div>
	    </div>
	<?php
	}
	?>

	<div class="sosumi">iNext (v<?php echo VERSION?>) by Clement T</div>

	<div class="dtdns">Bookmark new address :
		<a href="http://php-inext.rhcloud.comchange/">http://php-inext.rhcloud.comchange/</a>
	</div>


</body>
</html>
