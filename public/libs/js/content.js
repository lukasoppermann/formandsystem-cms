'use strict';

// run codemirror on every instance of .mark
mark(document.getElementsByClassName('mark'), {
	excludePanel: ['code'],
	lineNumbers: false
});
