 window.addEventListener('load',  (function() {

		if (!document.getElementById('share')) return;

		var title = document.title;

		var url = encodeURIComponent(document.getElementById('url').href);

		document.getElementById('email').addEventListener('click', (function(){
				var body = document.getElementsByClassName('content')[0].innerHTML;
				body += '<a href="' + url + '">' + url + '</a>';
				body = body.replace(/&lt;br\/&gt;/g, ' ');
				body = body.replace(/&amp;/g, '');
				body = body.replace(/\s+/g, ' ');
				body = body.replace(/<span class="photoCaption">/g, '<br><span class="photoCaption">');				
				location.href='mailto:?subject=' + title +'&body=<br>' + body;
			}),
			false
		);
		
		document.getElementById('twitter').addEventListener('click', (function(){
				window.location.href='twitter://post?message=' + title + ' ' + url;
				!window.document.webkitHidden && setTimeout(function(){
					setTimeout(function(){
					window.open('http://mobile.twitter.com/home?status=' + title + ' ' + url, 'twitter');
					}, 100);					
				}, 600);
			}),
			false
		);

		document.getElementById('facebook').addEventListener('click', (function(){
				//window.location.href='fb://publish?text=' + title + ' ' + url;
				//!window.document.webkitHidden && setTimeout(function(){
				//	setTimeout(function(){
					window.open('http://m.facebook.com/sharer.php?u=' + url + '&t=' + title, 'facebook');
				//	}, 100);					
				//}, 600);
			}),
			false
		);

                /*
		document.getElementById('delicious').addEventListener('click', (function(){
				window.open('http://m.delicious.com/save?url=' + url + '&title=' + title, 'delicious');
			}),
			false
		);
		
		document.getElementById('bitly').addEventListener('click', (function(){
				window.open('http://bitly.com/a/sidebar?u=' + url, 'bitly');
			}),
			false
		);
                */
		
	}),
	false
);
