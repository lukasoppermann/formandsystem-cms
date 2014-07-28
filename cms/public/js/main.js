'use strict';

require.config({
	baseUrl: "/js/bower_components",
	paths:{
		"dev": "../dev",
		'mark': "../dev/mark"
	}
});
 
require(['dev/engine/engine', 'dev/engine/functions/create'], function(_){
	window._ = _;
});
 
require(["mark/mark", "engine/engine",'engine/functions/on'], function(mark, _){
	// run codemirror on every instance of .mark
	mark('.mark', {
		excludePanel: ['code'],
		lineNumbers: false
	});
	mark('.mark').disable();
	_('.block').on('dblclick', function(){
		mark('.mark').enable();
	});
})

require(['engine/engine',"mark/mark", 'engine/plugins/serialize','engine/functions/on','engine/functions/parent','engine/functions/request'], function(_, mark){
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
		// _.request(_(this).parent('form')[0].getAttribute('action'),jsonstring, _('input[name="_method"]')[0].getAttribute('value'))
		_.request('http://api.formandsystem.com/v1/stream/'+_(this).parent('form')[0].getAttribute('data-article_id'),jsonstring, 'PUT')
		.success(function(r){
		}).error(function(){
		}).fail();
	});

	// _('.block').on('dblclick', function(){
	// 	if( _('.block-content',this)[0].getAttribute('data-type') === 'text' )
	// 	{
	// 		var range = mark(_('.block-content',this)[0])[0].doc.sel.ranges[0];
	// 		console.log(mark(_('.block-content',this)[0])[0].doc);
	// 		if( range.head.ch-range.anchor.ch > 1 )
	// 		{
	// 			return;
	// 		}
	// 	}
	// 	alert('settings');
	// },'.block-content');

	// add content
	_('.add-block').on('click', function(e){
		// console.log(e.target);
		if( this.getAttribute('data-type') === 'text' )
		{
			var n = document.createElement("section");
			n.setAttribute('class', 'block-content content-section');
			n.innerHTML = "<div class='block'><textarea data-column='12' data-type='text' class='mark block-content' placeholder='Add your content or double-click for settings.'></textarea></div>";
			_('#add_section').parent()[0].insertBefore(n,_('#add_section')[0]);
			mark('.mark', {
				excludePanel: ['code'],
				lineNumbers: false
			});
		}
	});
})

require(['engine/engine','engine/functions/on','engine/functions/class'],function(_) {
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
	paths: {
		'sortable': "../dev/jquery-sortable/jquery.sortable"
	},
	shim: {
    'sortable': ["../dev/jquery-sortable/jquery"],
	}
});

// require(["dev/jquery-sortable/jquery","sortable"],function($) {
// 	$('.content-section').sortable({
// 		items: '.block',
// 		forcePlaceholderSize: true
// 	});
// 	$('.page-content').sortable({
// 		items: '.content-section',
// 		handle: '.section-drag-handle'
// 	});
// })

require(['engine/engine', 'dev/engine-resizable/engine.resizable'], function(_){
	_('.content-section').resizable({
		handle: '.handle',
		columns: 12
		// resizing: function(width, container, e, opts){
		// 	var item = this;
		// 	if( widths.length == 0)
		// 	{
		// 		for(var i = 1; i <= opts.columns; i++)
		// 		{
		// 			widths.push(Math.floor(((container.css('width')-container.css('padding-left')-container.css('padding-right'))/opts.columns)*i));
		// 		}
		// 	}
		// 	widths.forEach(function(w, i){
		// 		if(width >= w + 20 && ( i+1 === columns || width <= widths[i+1] - 20) )
		// 		{
		// 			item.css('width', w+'px');
		// 			item.children('.block-content')[0].setAttribute('data-column',i);
		// 		}
		// 	});
		// }
	});
});


