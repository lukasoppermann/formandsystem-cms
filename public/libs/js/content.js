'use strict';

// run codemirror on every instance of .mark
mark(document.getElementsByClassName('mark'), {
	excludePanel: ['code'],
	lineNumbers: false
});


// scroll
(function(document){
	
	// scrollTop
	_('#contentnav').on('scroll', function(){
		console.log(this);
		console.log(_('#contentnav').css('height'));
		_('#scroll_indicator')[0].style.width = ((_('#contentnav').css('height')/100)*this.scrollTop)+'%';
	});
	
})(document);