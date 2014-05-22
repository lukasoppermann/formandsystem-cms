'use strict';

// run codemirror on every instance of .mark
mark(document.getElementsByClassName('mark'), {
	excludePanel: ['code'],
	lineNumbers: false
});


// scroll
(function(document){
	var scroll_indicator = _('#scroll_indicator');
	var contentnav = _('#contentnav');
	
	// scrollTop
	console.log(contentnav[0].scrollTop);
	
})(document);