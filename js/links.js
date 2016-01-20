window.addEventListener('load',  (function() {
	
	var noddy;
	
	document.addEventListener('click', function(event) {
		
		noddy = event.target;
		
		// Bubble up until we hit link or top HTML element. Warning: BODY element is not compulsory so better to stop on HTML
		while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
	        noddy = noddy.parentNode;
	    }

		// Check if it is a HTTP link		
		if( 'href' in noddy && (noddy.href.indexOf('http') == 0) )
		{	
			if (noddy.href.indexOf(document.location.host) !== -1)
			{					
				event.preventDefault();
				document.location.href = noddy.href;
			}
			else 
			{		
				event.preventDefault();
				document.getElementById('iframe').src = noddy.href;					
				document.body.setAttribute('class', 'overlaid');				
			}
		}
	
	},false);
	
    document.getElementById('close').addEventListener('click', function() {
		document.body.removeAttribute('class');    	
    });		


	}),
	false
);

