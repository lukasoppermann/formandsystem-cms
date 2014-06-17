'use strict';
require(['mark/mark'], function(mark){
	// run codemirror on every instance of .mark
	window.mark = mark;
	mark('.mark', {
		excludePanel: ['code'],
		lineNumbers: false
	});
})



require(['engine/engine', 'engine/plugins/serialize','engine/functions/on','engine/functions/parents','engine/functions/ajax'], function(_){
	window._ = _;
	// save json
	_('.save').on('click', function(){
		var data = _('.page-content').serialize({'item':'.block-content', 
			serialize: function(item, obj){
				if(obj.type === 'text')
				{
					console.log(item);
				}
			}
		});
		// send ajax
		_.post(_(this).parents('form')[0].getAttribute('action'), data);
	});
})

require(['engine/engine','engine/functions/on','engine/functions/addclass','engine/functions/removeclass'],function(_) {
	_('#contentnav').on('scroll', function(){
		if( this.scrollTop > 10 ){
			_('nav').addClass('scrolled');
		}
		else
		{
			_('nav').removeClass('scrolled');
		}
	});
})
