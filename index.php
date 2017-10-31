<?php
/*
Description   : iNext
Source        : http://hk.nextmedia.com/
Content Owner : nextmedia.com
Developer     : Clement T (https://github.com/chiunam)
*/


require('config.php');
require('header.php');

//Save Setting
if ($_POST['settingSubmit']==true)
{
    //save font size
    setcookie("fontsize", $_POST['fontsize'], COOKIES_LIFE, ROOT);
    setcookie("last-modified", time(), COOKIES_LIFE, ROOT);

    if ($_POST['cache'] == on) {
        setcookie("cache-since", time(), COOKIES_LIFE, ROOT);
    }
    header("Location: .");
}

//Init cookies
if (!$_COOKIE['fontsize'])
{
    setcookie("fontsize", "2", COOKIES_LIFE, ROOT);
    setcookie("last-modified", time(), COOKIES_LIFE, ROOT);
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
    <link href="<?php echo ROOT?>css/settings/" rel="stylesheet" type="text/css" media="screen">

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
            <?php foreach ($nextproxy as $id => $next) {?>
                <li><a href="<?php echo ROOT.$id.'/'?>"><?php echo $next["name"]?></a></li>
            <?php } ?>
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
                </form>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="sosumi">iNext (v<?php echo VERSION?>) by Clement T</div>

</body>
</html>
