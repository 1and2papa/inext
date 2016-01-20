function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
	  	if (x==c_name) {
	    	return unescape(y);
		}
	}
}

window.addEventListener('load',  (function() {
	
		if (!document.getElementById('back')) return;
	
		var n = (!document.getElementById('related')) ? 1 : parseInt(getCookie('depth'));
		
		if (isNaN(n)) n = 1;
		
		//Assign back button event
		var backBtn = document.getElementById('back');
		backBtn.addEventListener('click', function(e) {
			setCookie('depth', 1, 1);			
			e.preventDefault();
			window.history.go(n*-1);
		},false);

		//Set cookie for each related links
		var links = document.getElementsByClassName('related');
		
		for(var i=0; i < links.length; i++) {			
			links[i].addEventListener('click', function(e) {
				setCookie('depth', n+1, 1);
			},false);
		}
					
	}),
	false
);