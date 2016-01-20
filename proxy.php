<?
/*
Description		: NextProxy
Source			: http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer		: Clement T (http://chiunam.net)
Version			: 2.0.0
Create Date		: 2009-05-19
Last Update		: 2012-05-11
*/

//phpQUery for prasing DOM
require('phpQuery/phpQuery.php');
require('config.php');
require('function.php');
require('header.php');

header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Hong_Kong');
$time = localtime(time(), true);

//Initiate parameters
$param['next_id'] = ($_GET['next_id']) ? $_GET['next_id'] : 'apple';
$param['page'] = ($_GET['page']) ? $_GET['page'] : reset(array_keys($nextproxy[$param['next_id']]['url']));
$param['iss_id']  = ($_GET['iss_id']) ? $_GET['iss_id'] : '';
$param['art_id']  = ($_GET['art_id']) ? $_GET['art_id'] : '';
$param['name'] = $nextproxy[$param['next_id']]['name'];
$param['host'] = $nextproxy[$param['next_id']]['host'];
$param['img']  = $nextproxy[$param['next_id']]['img'];
$param['url']  = $nextproxy[$param['next_id']]['url'][$param['page']];
$param['realtime'] = ($param['next_id'] == 'applerealtime');

//Redirect to section index
if ($param['next_id'] == 'applerealtime' && !$_GET['sec_id'])
{
	$param['sec_id'] = reset(array_keys($nextproxy[$param['next_id']]['section']));	
	
	$loc = ROOT.$param['next_id'].'/'.$param['sec_id'].'/';
					
	header('Location: ' . $loc);		
}

if ($param['next_id'] == 'apple' && !$_GET['sec_id'])
{	
	$param['sec_id'] = reset(array_keys($nextproxy[$param['next_id']]['section']));
	$param['iss_id'] = date('Ymd', ($time['tm_hour'] < 4) ? (time() - 86400) : time());	
	
	$loc = ROOT.$param['next_id'].'/'.$param['sec_id'].'/'.$param['iss_id'].'/';
					
	header('Location: ' . $loc);	
}

if ($param['next_id'] == 'applesub' && !$_GET['sec_id'])
{	
	$param['sec_id'] = reset(array_keys($nextproxy[$param['next_id']]['section']));
	$param['iss_id'] = date('Ymd', ($time['tm_hour'] < 4) ? (time() - 86400) : time());	
	
	$loc = ROOT.$param['next_id'].'/'.$param['sec_id'].'/';
					
	header('Location: ' . $loc);	
}


if ($nextproxy[$param['next_id']]['section'])
{
	$param['sec_id']  = ($_GET['sec_id']) ? $_GET['sec_id'] : reset(array_keys($nextproxy[$param['next_id']]['section']));
	$param['iss_id']  = ($_GET['iss_id']) ? $_GET['iss_id'] : date('Ymd', ($time['tm_hour'] < 4) ? (time() - 86400) : time());
	$param['section'] = $nextproxy[$param['next_id']]['section'];
}


if (CACHE)
{
	//Return 304 if it is not the first visit
	if ($_SERVER['HTTP_IF_MODIFIED_SINCE'])
	{
		$last = strtotime(preg_replace('/;.*$/','',$_SERVER["HTTP_IF_MODIFIED_SINCE"]));
		
		if (time() - $last < CACHE_TIME)
		{
			header("HTTP/1.0 304 Not Modified");
			exit;
		}
	}
	
	//Don't cache on realtime news 
	$cache = CACHE_TIME;
	$cache *= ($param['realtime']) ? -1 : 1;

	//Send Cache Header for first visit //Webkit bugs, it does not work as expected
	header("Expires: " . gmdate('D, d M Y H:i:s', time()+$cache) . " GMT");
	header("Last-Modified: " . gmdate('D, d M Y H:i:s', time()+$cache) . " GMT");
	header("Cache-Control: public, max-age=".$cache.", must-revalidate");
	
}

//All your page are belong to us
print next_proxy($param);








function next_proxy($param)
{
	$url = $param['url'];

	//Adjust URL parameters
	foreach ( $param as $k=>$v )
	{
		if (!is_array($v)){
			$url = preg_replace('/%'.$k.'%/', $v, $url);
		}
	}

	$param['url'] = $url;

	//Parse URL
	$uri  = parse_url($url);
	$path = pathinfo($uri['path']);

    //Set user agent of file_get_contents
	ini_set('user_agent', USER_AGENT_BROWSER);

	//Cookie spoof
	$http_header['http']['header'] .= 'Cookie: FREE_TOKEN=1\r\n';

	//Add proxy
	if (PROXY != "") {
		$http_header['http']['proxy'] = PROXY;
		$http_header['http']['request_fulluri'] = true;
	}

	//Get page and assign to phpQuery
	//$html = file_get_contents($url, false, stream_context_create($http_header));
	$res = get_web_page($url);
	$html = $res['content'];

	//Convert non-ascii to html entities before load into phpQuery
	$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
	$req  = phpQuery::newDocumentHTML($html, 'UTF-8');


	//Remove all unnecessary attributes
	$req['*']->removeAttr('style')
			 ->removeAttr('align')
			 ->removeAttr('width')
			 ->removeAttr('height')
			 ->removeAttr('autofit')
			 ->removeAttr('onload');

	//Replace all noscript tags with its content
	foreach	($req['noscript'] as $noscript)
	{
		pq($noscript)->replaceWith( pq($noscript)->html() );
	}
		
	//Fix Images
	foreach	($req['img'] as $img)
	{
		if (!pq($img)->attr('alt'))
			pq($img)->attr('alt', "");
	}
	
	//Call page function
	eval ( '$doc = '.$param['next_id'].'_'.$param['page'].'($req, $param);' );
	
	pq($doc['head'])
		->append('<meta content="noindex,nofollow" name="robots">')
		->append(VIEWPORT)
		->append(ICON)
		->append('<link href="'.ROOT.CSS.'" rel="stylesheet" type="text/css" media="screen">')
		//->append('<script src="'.ROOT.'js/related.js" type="text/javascript"></script>')		
		//->append('<script src="'.ROOT.'js/links.js" type="text/javascript"></script>')		
		->append('<script src="'.ROOT.'js/share.js" type="text/javascript"></script>')
		->append('<script src="'.ROOT.'js/menu.js" type="text/javascript"></script>');
	
	if (CACHE) {
		pq($doc['head'])	
			->append('<script src="'.ROOT.'js/cache.js" type="text/javascript"></script>');
	}
		


	//CSS
	pq($doc['head'])
		->append('<link href="'.ROOT.'css/settings/" rel="stylesheet" type="text/css" media="screen">');

	pq($doc['#page'])
		->append( '<div class="sosumi">iNext v'.VERSION.'</div>' );
		
	pq($doc['body'])
//		->append(
//			'<div id="remote"><header><a id="close" class="button" href="javascript:;">關閉</a></header><iframe id="iframe" src=""></iframe></div>'
//		)
		->append( '<!--Source: '.$url.'-->' );

	return $doc;
}

function get_web_page( $url )
{
    $res = array();
    $options = array( 
        CURLOPT_RETURNTRANSFER => true,     			// return web page 
        CURLOPT_HEADER         => false,    			// do not return headers 
        CURLOPT_FOLLOWLOCATION => true,     			// follow redirects 
        CURLOPT_USERAGENT      => USER_AGENT_BROWSER,   // who am i 
        CURLOPT_AUTOREFERER    => true,     			// set referer on redirect 
        CURLOPT_CONNECTTIMEOUT => 120,      			// timeout on connect 
        CURLOPT_TIMEOUT        => 120,      			// timeout on response 
        CURLOPT_MAXREDIRS      => 10,       			// stop after 10 redirects 
        CURLOPT_PROXY          => PROXY,				// proxy
        CURLOPT_COOKIE         => "FREE_TOKEN=1",		// Cookie spoof
    ); 

    $ch      = curl_init( $url ); 
    curl_setopt_array( $ch, $options ); 
    $content = curl_exec( $ch ); 
    $err     = curl_errno( $ch ); 
    $errmsg  = curl_error( $ch ); 
    $header  = curl_getinfo( $ch ); 
    curl_close( $ch ); 

    $res['content'] = $content;     
    $res['err']		= $err;
    $res['errmsg']	= $errmsg;
    $res['header']	= $header;
        
    return $res; 
}  

?>
