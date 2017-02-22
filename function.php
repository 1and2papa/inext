<?php
/*
Description		: NextProxy functions
Source			: http://hk.nextmedia.com/
Content Owner	: nextmedia.com
Developer		: Clement T (http://chiunam.net)
*/


//Page functions: return a phpQuery DOM object

//Apple Daily Realtime Index
function applerealtime_index($req, $param)
{
	//Title
	$title = '<title>'.$param['name'].'-'.$param['section'][$param['sec_id']].'</title>';

	//Menu
	$menu = pq('<ul id="menu"></ul>')
			->append(menu());
				
	foreach ($param['section'] as $k => $v)
	{
		$href = ROOT.$param['next_id'].'/'.$k.'/';
		$class= ($param['sec_id']==$k) ? ' class="active"' : '';
		pq('<li><a href="'.$href.'"'.$class.'>'.$v.'</a></li>')->appendTo($menu);
	}

	
	//Page
	$page = page($param['section'][$param['sec_id']]);
	
	//List
	$list = pq('<ul class="list" />');
	
	foreach ($req['.RTitem'] as $div)
	{	
		$href = pq($div)->find('a')->attr('href');
		$href = proxyLink ($href, $param);
		
		$img  = pq($div)->find('img');
		$time = pq($div)->find('.time')->text() . ' ' .
				pq($div)->find('.date')->text();
		$text = pq($div)->find('.text')->text();
		
		pq('<li/>')
			->append(
				pq('<a href="'.$href.'"></a>')
					//->append($img)
					->append('<em>'.$time.'</em>')
					->append('<span>'.$text.'</span>')
			)
			->appendTo($list);
	}
	
	//Remove multiple whitespaces
	$list = preg_replace( '/\s+/', ' ', $list );	
	
	pq($list)->appendTo($page);	

	//Prepare doc
	$doc = phpQuery::newDocumentHTML('<!doctype html><html><body/></html>');

	pq($doc['head'])
		->append($title);

	pq($doc['body'])
		->attr('id', __FUNCTION__)
		->append($menu)
		->append($page);

	return $doc;
}

//Apple Daily Index
function apple_index($req, $param)
{
	//Append reload to invalid cache manifest
	if (stripos($_SERVER["REQUEST_URI"], '?reload'))
	{
		setcookie("reset-cache", 'YES', COOKIES_LIFE, ROOT);			
		header("Location: " . str_replace('?reload', '', $_SERVER["REQUEST_URI"]));		
	}	
	
	
	//Title
	$title = pq('<title>'. $param['section'][$param['sec_id']] .'</title>' );

	//Menu
	$menu = pq('<ul id="menu"></ul>')
			->append(menu());
				
	foreach ($param['section'] as $k => $v)
	{
		$href = ROOT.$param['next_id'].'/'.$k.'/'.$param['iss_id'].'/';
		$class= ($param['sec_id']==$k) ? ' class="active"' : '';
		pq('<li><a href="'.$href.'"'.$class.'>'.$v.'</a></li>')->appendTo($menu);
	}
	
	//Page
	$page = page($param['section'][$param['sec_id']]);
	
	//Get date from iss_id
    ereg("([0-9]{4})([0-9]{2})([0-9]{2})", $param['iss_id'], $regs);
	$today = mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]);

	//Archives
	$archive = pq('<form action="#" id="archive"></form>');

	//Compose selection box
	$select = pq('<select onchange="location.href=this.options[selectedIndex].value">');

	$value = ROOT.$param['next_id'].'/'.$param['sec_id'].'/'.$param['iss_id'].'/';
	pq('<optgroup label="現正瀏覽"><option value="'.$value.'" selected="selected">'.date("Y-m-d", $today).'</option></optgroup>')
		->appendTo($select);

	$value = ROOT.$param['next_id'].'/'.$param['sec_id'].'/';
	pq('<optgroup label="即日新聞"><option value="'.$value.'">即日新聞</option></optgroup>')
		->appendTo($select);

	$past = pq('<optgroup label="昔日新聞"></optgroup>');
	for ($i=1; $i<30; $i++) {
		$day = $today - $i*86400;
		$value = ROOT.$param['next_id'].'/'.$param['sec_id'].'/'.date("Ymd", $day).'/';
		pq('<option value="'.$value.'">'.date("Y-m-d", $day).'</option>')
			->appendTo($past);
	}
	pq($past)->appendTo($select);
	pq($select)->appendTo($archive);


	//Cover
	$cover = pq('<div class="cover">' . $req['#splash img:first'] . '</div>');
	pq($cover)->append($archive);

	//List
	$list = pq('<ul class="list" />');
	foreach ($req['#article_ddl optgroup'] as $optgroup) {
		pq('<li class="group">'. pq($optgroup)->attr('label') .'</li>')
			->appendTo($list);

		foreach (pq($optgroup)->children('option') as $option)
		{
			$href = pq($option)->attr("value");
			$href = str_replace("http://", "", $href);
			$href = str_replace($param['host'], "", $href);	
			$href = str_replace("/first/", "/art/", $href);		
			$href = ROOT . $param['next_id'] . $href;
			
			pq('<li><a href="'.$href.'">'. pq($option)->text() .'</a></li>')
				->appendTo($list);
		}
	}
	
	pq($page)
		->append($cover)
		->append($list);

	//Prepare doc
	$doc = phpQuery::newDocumentHTML('<!doctype html><html><body/></html>');

	//Add HTML5 cache manifest
	if (CACHE) {
		pq($doc['html'])
			->attr('manifest', ROOT.'cache.manifest.php');
	}

	pq($doc['head'])
		->append($title);

	pq($doc['body'])
		->attr('id', __FUNCTION__)
		->append($menu)
		->append($page);

	return $doc;
}

//Apple Daily Supplement Index
function applesub_index($req, $param)
{
	//Append reload to invalid cache manifest
	if (stripos($_SERVER["REQUEST_URI"], '?reload'))
	{
		setcookie("reset-cache", 'YES', COOKIES_LIFE, ROOT);			
		header("Location: " . str_replace('?reload', '', $_SERVER["REQUEST_URI"]));			
	}	
	
	
	//Remove unnecessary elements
	$req['.BigblueboxSpace']->remove();	
	
	//Title
	$title = '<title>'.$param['name'].'-'.$param['section'][$param['sec_id']].'</title>';

	//Menu
	$menu = pq('<ul id="menu"></ul>')
			->append(menu());
				
	foreach ($param['section'] as $k => $v)
	{
		$href = ROOT.$param['next_id'].'/'.$k.'/';
		$class= ($param['sec_id']==$k) ? ' class="active"' : '';
		pq('<li><a href="'.$href.'"'.$class.'>'.$v.'</a></li>')->appendTo($menu);
	}
	
	//Page
	$page = page($param['section'][$param['sec_id']]);
	
	//List
	$list = pq('<ul class="list" />');
	
	foreach ($req['.subpage > div'] as $div)
	{
		$date = pq($div)->find('.date')->text();
		
		foreach (pq($div)->find('.col02 tr') as $tr)
		{
			//Link
			$a = pq($tr)->find('a');
			$href = $a->attr('href');
			$href = proxyLink ($href, $param);

			//Key
			$key   = pq($tr)->find('.key')->text();
			
			//Text
			$text  = pq($a)->find('.text')->text();
			
			//Author
			if ( preg_match('/\/columnist\/([^\/]+)\/art\//', $a->attr('href'), $matches) > 0)
				$text .= '('.urldecode($matches[1]).')';
			
			if ($text != "") $text = pq('<em>'.$text.'</em>');			
			
			//Subject
			pq($a)->find('.text')->remove();
			$subj  = pq($a)->text();
			
			
			//Compose <li>
			pq('<li/>')
				->append(
					pq('<a href="'.$href.'"></a>')
						->append('<em>'.$date.' - '.$key.'</em>')
						->append('<span>'.$subj.'</span>')
						->append($text)
				)
				->appendTo($list);
		}
	}
	
	pq($page)->append($list);
	
	//Remove multiple whitespaces
	$list = preg_replace( '/\s+/', ' ', $list );		

	//Prepare doc
	$doc = phpQuery::newDocumentHTML('<!doctype html><html><body/></html>');

	pq($doc['head'])
		->append($title);

	pq($doc['body'])
		->attr('id', __FUNCTION__)
		->append($menu)
		->append($page);

	return $doc;
}

//Apple Daily Realtime Articles
function applerealtime_realtime($req, $param)
{
	return apple_art($req, $param);
}

//Apple Daily first article
function apple_first($req, $param)
{
	return apple_art($req, $param);
}
//Apple Daily Supplement article
function applesub_art($req, $param)
{
	return apple_art($req, $param);	
}

//Apple Daily articles
function apple_art($req, $param)
{
	
	//Append reload to invalid cache manifest
	if (stripos($_SERVER["REQUEST_URI"], '?reload'))
	{
		setcookie("reset-cache", 'YES', COOKIES_LIFE, ROOT);			
		header("Location: " . str_replace('?reload', '', $_SERVER["REQUEST_URI"]));		
	}	
	
	
	//Remove unnecessary elements
	$req['.clear']->remove();	
	$req['.FloatLeftImg1']->remove();
	$req['#fb_like']->remove();	
	$req['#video_player input']->remove();
	
	
	//Unwrap content DIVs
	foreach ($req['.ArticleContent_Outer'] as $div)
	{	
		pq($div)->replaceWith( pq($div)->find('.ArticleContent_Inner')->html() );
	}
	
	//Photos	
	foreach ($req['.photo, .photo_left, .photo_right'] as $div)
	{
		//Captions
		pq($div)
			->find('span')
			->remove();
		
		pq($div)
			->find('a')
			->removeAttr('rel')
			->attr('target', '_blank')
			->append('<span class="photoCaption">'.pq($div)->find('img')->attr('title').'</span>');
			
		//Align class name	
		pq($div)
			->removeClass('photo')
			->removeClass('photo_left')
			->removeClass('photo_right')
			->addClass('photo');
	}
	
	//Article photos
	foreach ($req['.photo_center'] as $div)
	{
		pq($div)
			->find('a')
			->removeAttr('rel')
			->attr('target', '_blank')
			->wrap('<div class="photo"></div>');		

		pq($div)
			->find('span')
			->addClass('photoCaption');		
			
		pq($div)
			->replaceWith( pq($div)->find('td')->html() );
	}
	
	//Videos
	$videos = pq('<div/>');	
		
	$req['#video_player']
		->addClass('video');

	//MP4	
	$script = $req['#video_player script'];
	
	//Find poster image
	preg_match("/http:\/\/.*\.jpg/", $script, $matches);	
	$poster = $matches[0];

	$mp4 = preg_match_all("/http:\/\/.*\.mp4/", $script, $matches);
	
	if ($mp4 > 0)
	{
		foreach ($matches as $src)
		{
			$videos->append(
				pq('<video controls=controls poster="'.$poster.'"></video>')
					->append('<source src="'.$src[0].'" type="video/mp4" />')
				);
		}
	}
	
	$script->replaceWith($videos);			

	
	//Youtube	
	$object = $req['#video_player object'];
		
	$youtube = $object->find('param[name=movie]')->attr('value');
	
	if ($youtube != "")
	{
		preg_match("/\/v\/([^?]+)/", $youtube, $matches);
		$yid = $matches[1];
	
		$videos->append(
			pq('<iframe width="290" height="163"
					src="http://www.youtube.com/embed/'.$yid.'"
					frameborder="0" allowfullscreen></iframe>')
		);		
	}
	
	$object->replaceWith($videos);
	
	
	//Youku
	$embed = $req['#video_player embed'];
	
	$youku = $embed->attr('src');	
	
	if ($youku != "")
	{
		$youku = str_replace('player.youku.com', 'v.youku.com', $youku);
		$youku = str_replace('/player.php/sid/', '/v_show/id_', $youku);		
		$youku = str_replace('/v.swf', '.html', $youku);				
		
		$videos->append(
			pq('<span class="photoCaption"><a href="'.$youku.'" target="_blank">View on Youku</a></span>')
		);		
	}
	
	$embed->replaceWith($videos);
	
	

	//Title
	if ($req['#article_ddl option[selected]']->text() != "")
		$title = pq( '<title>'. $req['#article_ddl option[selected]']->text() .'</title>' );
	else
		$title = pq( '<title>'. $req['#articleContent h1']->text() .'</title>' );

	//Menu
	$menu = pq('<ul id="menu"></ul>')
			->append(menu());
			
	foreach ($param['section'] as $k => $v)
	{
		$href = ROOT.$param['next_id'].'/'
					.$k.'/';
					
		if (!$param['realtime'])
			$href .= $param['iss_id'].'/';

		$class= ($param['sec_id']==$k) ? ' class="active"' : '';

		pq('<li><a href="'.$href.'"'.$class.'>'.$v.'</a></li>')->appendTo($menu);
	}
	
	//Page
	$page = page($param['section'][$param['sec_id']]);			

	//Content
	$content = pq('<div class="content"></div>');
	
	//Title
	$content->append($req['.LHSBorderBox h1']);

	//Publication date
	if ( $req['.pub_date']->size() > 0 )
	{
		$content->append(
			pq('<em class="pubdate">')
				->append($req['.pub_date']->text())
				->append('<br>')
				->append($req['.last_update']->text())
		);
	}
	
	//Article		
	$content->append($req['.LHSBorderBox .photo'])
			->append($req['#masterContent'])
			->append($req['.FloatLeftImg']);
			
	//Remove uncessary HTML comment
	$content = preg_replace( '/<!--[^-]*-->/', '', $content );	

	//Remove multiple whitespaces
	$content = preg_replace( '/\s+/', ' ', $content );	
			
			
	//Auxiliary
	$auxiliary = pq('<div id="auxiliary" class="content"></dvi>');

	//Back To Main
	if (!$param['realtime']) $iss_id = $param['iss_id'].'/';
	$btm = '<p id="btm"><a class="back" href="'.ROOT.$param['next_id'].'/'.$param['sec_id'].'/'.$iss_id.'">&#171; 返回</a></p>';

	//Orignial Link
	$ori = '<p id="original"><a id="url" href="' . $param['url'] . '" target="_blank">瀏覽網頁版 &#187;</a></p>';

	$auxiliary->append(
		pq('<div class="auxiliary"></div>')
			->append($btm)
			->append($ori)
	);

	//Related articles
	foreach ($req['.ArticlePager a'] as $a)
	{
		$href = pq($a)->attr("href");
		$href = proxyLink ($href, $param);
		
		pq($a)
			->attr('href', $href)
			->attr('class', "related")
			->wrap('<li></li>');
	}

	if ( $req['.ArticlePager a']->size() > 0 )
	{	
		$auxiliary->append(
					pq('<div id="related"></div>')
						->append('<p>'.$req['.ArticlePager .RelateArticle']->text().'</p>')
						->append(
							pq('<ul>')->append($req['.ArticlePager li'])
						)
				);
	}
	
	pq($page)
		->append($content)
		->append($auxiliary)
		->append(share());	

	//Prepare doc
	$doc = phpQuery::newDocumentHTML('<!doctype html><html><body/></html>');
	
	//Add HTML5 cache manifest	
	if (CACHE) {
		pq($doc['html'])
			->attr('manifest', ROOT.'cache.manifest.php');
	}		

	pq($doc['head'])
		->append($title)
		->append('<script type="text/javascript" src="http://staticlayout.apple.nextmedia.com/template/common/scripts/replacelink.js"></script>');		

	pq($doc['body'])
		->attr('id', __FUNCTION__)
		->append($menu)
		->append($page)
		->append('<script type="text/javascript"> com.atnext.page.utilities.LinkReplacer.replaceLink(document.getElementById("masterContent")); </script>');

	return $doc;
}





//Common functions
function page ($title)
{
	$page = pq('<div id="page"><div id="close-mask"></div></div>');
	pq($page)
		->append(
			pq('<header><div class="trigger"></div><p>'.$title.'</p><div class="reload"></div></header>')
		);
	
	return $page;
}

function share ()
{
	$share = pq('<div id="share"><p></p></div>');

	pq($share['p'])
		->append('<a id="email" href="javascript:;"><img src="'.ROOT.'images/email.png" alt="Email"/></a>')
		->append('<a id="twitter" href="javascript:;"><img src="'.ROOT.'images/twitter.png" alt="Twitter"/></a>')
		->append('<a id="facebook" href="javascript:;"><img src="'.ROOT.'images/facebook.png" alt="Facebook"/></a>');
		//->append('<a id="delicious" href="javascript:;"><img src="'.ROOT.'images/delicious.png" alt="delicious"/></a>')
		//->append('<a id="bitly" href="javascript:;"><img src="'.ROOT.'images/bitly.png" alt="bitly"/></a>');

	return $share;
}

function proxyLink ($nextLink, $param)
{
	$nextLink = str_replace("http://", "", $nextLink);
	$nextLink = str_replace("s.nextmedia.com", "", $nextLink);
	$nextLink = str_replace($param['host'], "", $nextLink);	
	$nextLink = str_replace("supplement/", "", $nextLink);	
	$nextLink = preg_replace('/\/apple\/a\.php\?i=([0-9]+)&sec_id=[0-9]+&s=0&a=([0-9]+)/', '/news/art/$1/$2', $nextLink);
	$nextLink = preg_replace('/\/realtime\/a\.php\?i=([0-9]+)&s=[0-9]+&a=([0-9]+)/', '/all/realtime/$1/$2', $nextLink);
	$nextLink = preg_replace('/\/columnist\/[^\/]+\/art\//', '/columnist/art/', $nextLink);	
	$nextLink = preg_replace('/\/realtime\/[a-z]+\//', '/'.$param['sec_id'].'/realtime/', $nextLink);
	$nextLink = str_replace("enews/realtime/", $param['sec_id']."/realtime/", $nextLink);	
	$nextLink = ROOT . $param['next_id'] . $nextLink;
	
	return $nextLink;
}




function jsonDecode ($str)
{
	//Fix json quotation
	$str = preg_replace("/([a-zA-Z0-9_]+?):/" , '"$1":', $str);
	$str = preg_replace("/'([a-zA-Z0-9_]+?)':/" , '"$1":', $str);

	$str = preg_replace("/:([a-zA-Z0-9_]+?)/", ':"$1"', $str);
	$str = preg_replace("/:'([a-zA-Z0-9_]+?)'/", ':"$1"', $str);

	return json_decode($str, true);
}

function base64Image ($url)
{
	//Parse URL
	$uri  = parse_url($url);
	$path = pathinfo($uri['path']);

	$http_header['http']['header'] = 'User-Agent: '.USER_AGENT_GOOGLEBOT.'\r\n';
	if (PROXY != "") $http_header['http']['proxy'] = PROXY;

	$data = file_get_contents($url, false, stream_context_create($http_header));

	return 'data:image/'.$path['extension'].';base64,'.base64_encode($data);
}

function cleanXML ($str)
{
	$patterns[0] = '/&lt;/';
	$patterns[1] = '/&gt;/';
	$patterns[2] = '/&amp;#/';
	$replacements[0] = '<';
	$replacements[1] = '>';
	$replacements[2] = '&#';

	return preg_replace($patterns, $replacements, $str);
}

function createLinks ($str)
{
	//Hyperlink
	$str = preg_replace("/https?:\/\/[a-z0-9-_\.\/\?\=&]+/i", "<a href='$0' target='_blank'>$0</a>", $str);
	//Mailto
	$str = preg_replace("/mailto:([a-z0-9-_\.@]+)/i", "<a href='$0'>$1</a>", $str);

	return $str;
}


function video ($param)
{	
	$site = 'http://hk.apple.nextmedia.com';
	
	$dir = ($param['next_id'] == 'applesub') ? 'apple_sub' : $param['next_id'];
	
	$json = file_get_contents( $site . '/template/' . $dir . '/cache/' . $param['iss_id'] . '/video_art.js' );
	
	if (!$json) return '';
		
	$videos = json_decode($json, true);
	
	foreach ($videos as $video) {
		
		if ($video['SECTION_ID'] == $param['sec_id'] && $video['ARTICLE_ID'] == $param['art_id']) {

			//apple video path:		/admedia/20110427/27042011_accm_05_Video.mp4
			//apple_sub video path	/admedia/20110427/Vsub03_Video.mp4 HTTP/1.1 						
			
			if ($param['next_id'] == 'applesub') {
				preg_match('/([^_]+)\.jpg$/', $video['AV_IMAGE1'], $matches);
			} else {
				preg_match('/([^\/]+)\.jpg$/', strtolower($video['AV_IMAGE1']), $matches);
			}
			
			//file name adjustment
			$video_file = 	str_replace('00', '0', $matches[1]);
			$video_file = 	str_replace('_a', '_A', $video_file);
			$video_path = 	'http://hk.applevideo.nextmedia.com' . '/admedia/' . $param['iss_id'] . '/' . $video_file . '_Video.mp4';
			
			//use apple mobile site url for inserting video tag so that it can be shown in normal safari
			$video_src =	'http://hkm.appledaily.com/Home/TV?i=370hssv0773h' . // Hello Asshole
							'&u=' . urlencode ($video_path);
			
			$video_html = 	'<div class="videoPanel">' . 
							'<video src="'.$video_src.'" poster="'.$site.$video['AV_IMAGE2'].'" controls="controls">' .
							'<a href="'.$video_path.'">Download Video</a></video>' . 
							'<p class="videoCaption">' . $video['CAPTION'] .
							'</p>' . 
							'</div>';

			return $video_html;
			
			break;
			
		}
		
	}
	
	return '';	
}

function menu()
{
	return
	'<li><a href="'.ROOT.'" class="home">主頁</a></li>';
}

/*
function clearCache()
{
	//Prepare doc
	$doc = phpQuery::newDocumentHTML('<!doctype html><html><body/></html>');
	
	//Cache manifest	
	pq($doc['html'])
		->attr('manifest', ROOT.'cache.manifest.php');
	
	$url = str_replace('?reload', '', $_SERVER["REQUEST_URI"]);

	pq($doc['head'])
		->append('<title>Please wait...</title>')
		->append('<meta http-equiv="refresh" content="20;url='.$url.'">');			
		
	return $doc;
}*/

?>
