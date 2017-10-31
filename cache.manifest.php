<?php
/*
Description   : NextProxy Cache Manifest
Source        : http://hk.nextmedia.com/
Content Owner : nextmedia.com
Developer     : Clement T (https://github.com/chiunam)
*/

require('config.php');

header("Content-type: text/cache-manifest");

if ($_COOKIE['reset-cache'])
{
    // Clear cookie
    setcookie("reset-cache", "", time()-60*60*24*30, ROOT);

    // Invalid cache manifest
    header("HTTP/1.0 404 Not Found");
    die('HTTP/1.0 404 Not Found');
}
else
{
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
}
?>
CACHE MANIFEST

# v<?php echo VERSION?>

<?php if (CACHE) { ?>

CACHE:
inext.png
js/links.js
js/related.js
js/share.js
js/menu.js
css/back.png
css/bg.png
css/button.png
css/gloss.png
css/home.png
css/reload.png
css/listGroup.png
css/pinstripes.png
css/trigger.png
css/style.css
images/delicious.png
images/email.png
images/facebook.png
images/twitter.png

<?php } ?>

NETWORK:
*
