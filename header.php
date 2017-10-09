<?php
/*
Description		: iNext auth
Source        : http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer     : Clement T (https://github.com/chiunam)
*/


//Check UA
if (!eregi(ALLOWED_UA, $_SERVER['HTTP_USER_AGENT']))
	exit(MOTTO);

if (!MOD_REWRITE)
	exit("Please config mod_rewrite");
?>
