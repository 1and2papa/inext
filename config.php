<?php
/*
Description		: NextProxy Configuration
Source			: http://hk.nextmedia.com/
Content Owner		: nextmedia.com
Developer		: Clement T (http://chiunam.net)
*/

define("VERSION", "3.0.2");
define("ALLOWED_UA", "iPhone|iPod|iPad|Android");
define("MOTTO", "All your page are belong to us");
define("SITE", "http://php-inext.rhcloud.com");
define("COOKIES_LIFE", time()+60*60*24*30);
define("ROOT", "/");
define("CACHE", false);
define("CACHE_TIME", 7200);
define("MOD_REWRITE", true);
define("EMBED_IMAGE", false);
define("IMAGE_PROXY", false);
define("USER_AGENT_GOOGLEBOT", "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
define("USER_AGENT_BROWSER", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.5 Safari/534.55.3");
define("VIEWPORT", '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">');
define("ICON", '<link rel="apple-touch-icon" href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].ROOT.'icon.png">');
define("CSS", 'css/style.css');
define("PROXY", "");

error_reporting(0);

//NextProxy config
$nextproxy = array(
	"applerealtime" => array(
		"name" => "蘋果即時新聞",
		"host" => "hk.apple.nextmedia.com",
		"section" => array(
			"all"			=> "最新",
			"top"			=> "最hit",
			"news"			=> "要聞",
			"finance"		=> "財經",
			"entertainment"		=> "娛樂",
			"china"			=> "兩岸",
			"international"		=> "國際",
			"sports"		=> "體育",
			"videonews"		=> "影片"
		),
		"url" => array(
			"index"		=> "http://%host%/realtime/realtimelist/%sec_id%",
			"realtime"	=> "http://%host%/realtime/%sec_id%/%iss_id%/%art_id%"
		)
	),
	"apple" => array(
		"name" => "蘋果日報",
		"host" => "hk.apple.nextmedia.com",
		"section" => array(
			"news"		=> "要聞港聞",
			"international"	=> "兩岸國際",
			"financeestate"	=> "財經地產",
			"entertainment"	=> "娛樂",
			"sports"	=> "體育"
		),
		"url" => array(
			"index" => "http://%host%/%sec_id%/index/%iss_id%/",
			"first" => "http://%host%/%sec_id%/first/%iss_id%/%art_id%",
			"art" => "http://%host%/%sec_id%/art/%iss_id%/%art_id%"
		)
	),
	"applesub" => array(
		"name" => "蘋果日報副刊",
		"host" => "hk.apple.nextmedia.com",
		"section" => array(
			"food" 		=> "飲食",
			"travel"	=> "旅遊",
			"tech"		=> "科技",
			"retails"	=> "消費",
			"culture"	=> "文化",
			"car"		=> "汽車",
			"health"	=> "健康",
			"apple"		=> "蘋果樹下",
			"columnist"	=> "名采",
			"service" 	=> "暖流",
			"night" 	=> "豪情",
			"column"	=> "專欄"
		),
		"url" => array(
			"index"	=> "http://%host%/supplement/sectionlistpaging/%sec_id%/0",
			"art" 	=> "http://%host%/supplement/%sec_id%/art/%iss_id%/%art_id%"
		)
	),
);
?>
