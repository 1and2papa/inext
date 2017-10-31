<?php
/*
Description   : NextProxy Configuration
Source        : http://hk.nextmedia.com/
Content Owner : nextmedia.com
Developer     : Clement T (https://github.com/chiunam)
*/

define("VERSION", "3.1.0");
define("ALLOWED_UA", "iPhone|iPod|iPad|Android");
define("MOTTO", "All your page are belong to us");
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
define("ICON", '<link rel="apple-touch-icon" href="'.ROOT.'icon.png">');
define("CSS", 'css/style.css');
define("PROXY", "");

error_reporting(0);

//NextProxy config
$nextproxy = array(
    "daily" => array(
        "name" => "今日蘋果",
        "host" => "hk.news.appledaily.com",
        "section" => array(
            "local" => "要聞港聞",
            "international" => "兩岸國際",
            "finance" => "財經地產",
            "entertainment" => "娛樂",
            "sports" => "體育"
        ),
        "url" => array(
            "index" => "https://%host%/daily/%sec_id%/",
            "article" => "https://%host%/%sec_id%/daily/article/%iss_id%/%art_id%"
        )
        ),
    "lifestyle" => array(
        "name" => "果籽",
        "host" => "hk.lifestyle.appledaily.com",
        "section" => array(
            "food" => "飲食",
            "special" => "專題",
            "travel" => "旅遊",
            "tech" => "科技",
            "retails" => "品味",
            "car" => "汽車",
            "culture" => "文化",
            "family" => "親子",
            "columnist" => "名采",
            "luck" => "運程"
        ),
        "url" => array(
            "index" => "https://%host%/supplement/sectionlistpaging/%sec_id%/0",
            "article" => "https://%host%/lifestyle/%sec_id%/daily/article/%iss_id%/%art_id%"
        )
    ),
    "magazine" => array(
        "name" => "周刊",
        "host" => "hk.lifestyle.appledaily.com",
        "section" => array(
            "etw" => "飲食男女",
            "ketchuper" => "Ketchuper",
            "nextplus" => "壹週Plus"
        ),
        "url" => array(
            "index" => "https://%host%/magazine/%sec_id%/",
            "article" => "https://%host%/%sec_id%/magazine/article/%iss_id%/%art_id%"
        )
    ),
    "realtime" => array(
        "name" => "即時新聞",
        "host" => "hk.news.appledaily.com",
        "section" => array(
            "top" => "焦點",
            "local" => "要聞",
            "breaking" => "突發",
            "entertainment"=> "娛樂",
            "china" => "兩岸",
            "international" => "國際",
            "finance" => "財經",
            "lifestyle" => "果籽",
            "sports" => "體育",
            "etw" => "飲食男女",
            "ketchuper" => "Ketchuper",
            "racing" => "賽馬"
        ),
        "url" => array(
            "index" => "https://%host%/realtime/realtimelist/%sec_id%",
            "article" => "https://%host%/top/realtime/article/%iss_id%/%art_id%"
        )
    ),
);
?>
