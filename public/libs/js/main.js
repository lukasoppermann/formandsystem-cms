'use strict';
require(['mark/mark'], function(mark){
	// run codemirror on every instance of .mark
	mark('.mark', {
		excludePanel: ['code'],
		lineNumbers: false
	});
})

require(['engine/engine','mark/mark', 'engine/plugins/serialize','engine/functions/on','engine/functions/parents','engine/functions/request'], function(_, mark){
	window._ = _;
	// save json
	_('.save').on('click', function(){
		var data = _('.page-content').serialize({'item':'.block-content', 
			serialize: function(item, obj){
				if(obj.type === 'text')
				{
					return {
						'content': mark(item).get(true)
					};
				}
			}
		});
		var jsonstring = "content="+data+"&title="+_('.headline')[0].value;
		// send ajax
		_.request(_(this).parents('form')[0].getAttribute('action'),jsonstring, _('input[name="_method"]')[0].getAttribute('value'))
		.success(function(r){
		}).error().fail();
	});
	
	_('.block').on('dblclick', function(){
		if( _('.block-content',this)[0].getAttribute('data-type') === 'text' )
		{
			var range = mark(_('.block-content',this)[0])[0].doc.sel.ranges[0];
			console.log(mark(_('.block-content',this)[0])[0].doc);
			if( range.head.ch-range.anchor.ch > 1 )
			{
				return;
			}
		}
		alert('settings');
	},'.block-content');
	
	// add content 
	_('.add-block').on('click', function(e){
		console.log(e.target);
		if( this.getAttribute('data-type') === 'text' )
		{
			var n = document.createElement("section");
			n.setAttribute('class', 'block-content content-section');
			n.innerHTML = "<div class='block'><textarea data-column='12' data-type='text' class='mark block-content' placeholder='Add your content or double-click for settings.'></textarea></div>";
			_('#add_section').parents()[0].insertBefore(n,_('#add_section')[0]);
			mark('.mark', {
				excludePanel: ['code'],
				lineNumbers: false
			});
		}
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
require.config({
	'paths': {
		'jquery' : 'jquery-sortable/jquery'
	}
});
require(['jquery','jquery-sortable/jquery.sortable'],function($) {
	$('.content-section').sortable({
		items: '.block',
		forcePlaceholderSize: true
	});
	$('.page-content').sortable({
		items: '.content-section',
		handle: '.section-drag-handle'
	});
})
