 window.addEventListener('load',  (function() {
 	
    var body = document.body,
		trigger = document.querySelectorAll('#page .trigger')[0],
		closeMask = document.getElementById('close-mask');

    trigger.addEventListener('click', function() {
        if (hasClass(body, 'menu-open')) {
            hideMenu();
        } else {
            showMenu();
        }   
    });

    closeMask.addEventListener('click', function(e) {
        e.preventDefault();
        hideMenu();
    });
    
	var menus = document.getElementById('menu').getElementsByTagName("a");
	
	for(var i=0; i < menus.length; i++) {			
		menus[i].addEventListener('click', function(e) {
			hideMenu();
		},false);
	}    

    function showMenu() {
        body.setAttribute('class', 'menu-open');
        closeMask.style.display = 'block';  
    }

    function hideMenu() {
        body.removeAttribute('class');
        closeMask.style.display = 'none';
    }

    function hasClass(el, selector) {
          var className = " " + selector + " ";             
        return (el.nodeType === 1 && (" " + el.className + " ").replace(/[\n\t\r]/g, " ").indexOf(className) > -1);
    }
    
	var reload = document.querySelectorAll('#page .reload')[0];

    reload.addEventListener('click', function() {
    	window.location = window.location + '?reload';
    });	
	
	}),
	false
);