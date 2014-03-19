'use strict';

// run codemirror on every instance of .mark
Array.prototype.slice.call(document.getElementsByClassName('mark'),0).forEach(function(editor){
	options.cm = CodeMirror.fromTextArea(editor, {
		theme: "mark",
    // value: "function myScript(){return 100;}\n",
		mode: {
			name: "gfm",
			highlightFormatting: true
		},
		lineNumbers: false,
		addModeClass: false,
		lineWrapping: true,
		flattenSpans: true,
		cursorHeight: 1,
		matchBrackets: true,
		autoCloseBrackets: { pairs: "()[]{}''\"\"", explode: "{}" },
		matchTags: true,
		showTrailingSpace: true,
		autoCloseTags: true,
		styleSelectedText: false,
		styleActiveLine: true,
		placeholder: "",
		tabMode: 'indent',
		tabindex: "2",
		dragDrop: false,
		extraKeys: {
			"Enter": "newlineAndIndentContinueMarkdownList",
			"Cmd-B": function(){
				options.fn.inlineFormat({'format':'strong'});
			},
			"Ctrl-B": function(){
				options.fn.inlineFormat({'format':'strong'});
			},
			"Cmd-I": function(){
				options.fn.inlineFormat({'format':'em'});
			},
			"Ctrl-I": function(){
				options.fn.toggleFormat('quote', {"level":2});
			}
		}
	});
	// add edit Options
	options.cm.on("cursorActivity", function(){
		editOptions();
		// options.fn.inlineFormat({'format':'em'});
						// console.log( '##'+options.cm.getSelection().match( /(?:^|[^_*])_*([*](?:[*]{2})*)?[^*_]+\1_*(?:[^*_]|$)/gm )+'##' );
	});
});
