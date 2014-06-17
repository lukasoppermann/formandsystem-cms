'use strict';
// require(['mark/mark'], function(mark){
// 	// run codemirror on every instance of .mark
// 	mark('.mark', {
// 		excludePanel: ['code'],
// 		lineNumbers: false
// 	});
// })



require(['engine/engine','engine/functions/children','engine/functions/css','engine/functions/addclass','engine/plugins/serialize'], function(_){
	window._ = _;
	window.engine = _;
	// var thedata = _('.page-content').serialize({'item':'.block-content', 
	// 	serialize: function(item, obj){
	// 		if(obj.type === 'text')
	// 		{
	// 			console.log(item);
	// 		}
	// 	}
	// });
	// console.log(JSON.parse(thedata));
})

require(['engine/engine'
,'engine/functions/on'
,'engine/functions/off'
,'engine/functions/addclass'
,'engine/functions/removeclass'
,'engine/functions/children'
,'engine/functions/parents'
],
	function(_) {
		window._ = _;
		_('#contentnav').on('scroll', function(){
			_('#scroll_indicator')[0].style.width = ((_('#contentnav').css('height')/100)*this.scrollTop)+'%';
		});
})
