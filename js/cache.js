window.addEventListener('load', function(e) {
	
	// Check if a new cache is available on page load.	
	window.applicationCache.addEventListener('updateready', function(e) {
		if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
			// Browser downloaded a new app cache.
			// Swap it in and reload the page to get the new hotness.
			window.applicationCache.swapCache();
			window.location.reload();
		}
		else {
			
			// Manifest didn't changed. Nothing new to server.
		}
	}, false);
	
	
	// Reset cache
	window.applicationCache.addEventListener('obsolete', function(e) {
		if (window.applicationCache.status == window.applicationCache.OBSOLETE) {
			// App cache obsolete.
			// Swap it in and reload the page to get the new hotness.
			window.applicationCache.swapCache();
			window.location.reload();			
		}
		else {
			// Manifest still valid
		}		
	}, false);
		
}, false);