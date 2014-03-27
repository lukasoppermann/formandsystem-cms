'use strict';

// run codemirror on every instance of .mark
Array.prototype.slice.call(document.getElementsByClassName('mark'),0).forEach(function(editor){
	mark(editor, {
		excludePanel: ['code'],
		lineNumbers: false
	});
});
