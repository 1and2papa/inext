<?php
/*
Description		: iNext auth
Source			: http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer		: Clement T (http://chiunam.net)
Version			: 2.0.0
Create Date		: 2009-05-19
Last Update		: 2012-05-11
*/


//Check UA
if (!eregi(ALLOWED_UA, $_SERVER['HTTP_USER_AGENT']))
	exit(MOTTO);

if (!MOD_REWRITE)
	exit("Please config mod_rewrite");
?>
