// ----------------------------------------------------
// Dialog Class
//
// dependencies
// fs.base.js 
// - fs_resizes()
//
// TODO:
// - implement localStorage caching
// ----------------------------------------------------
// define functions 
;(function( $, window, document )
{
	var _this, _overlay, _body = $('body'), _dialog_content, _dialog_wrapper, _inner_wrapper;
	// methods
	var methods = {
		// settings object
		settings: {},
		// animations object
		fx: {
			slide: function()
			{
				methods.position();
				var top = _this.css('top');
				_this.css({'top':-_this.height()+50}).show().animate({'top':top,'marginTop':'+=10'}, methods.settings.speed,
				methods.settings.easing).animate({'marginTop':'-=10'}, 200, methods.settings.easing);
			}
		},
		// functions object
		fn: {
			ajax: function( args, cache_name )
			{
				// merge options
				var opts = $.extend({
					type: 		'post',
					dataType: 	'html',
					fns: 		{}
				}, args);
				var output;
				// send request
				$.ajax({
					type : opts.type,
					data: opts.data,
					dataType: opts.dataType,
					url: opts.url
				}).done(function( response )
				{
					if( opts.fns.success )
					{
						methods.update(response, cache_name, opts.fns.success);
					}
					else
					{
						methods.update(response, cache_name);
					}
				}
				).fail(function( r )
				{
					if( opts.fns.error )
					{
						return opts.fns.error( response );
					}
					else
					{
						return false;
					}
				});
			}
		},
		// cache object
		cache: {},
		// initialize dialog box
	    init: function( settings, content ) 
		{ 
			// Extend default options with those provided
			methods.settings = $.extend({}, $.fn.fs_dialog.defaults, settings);
			// chache selection
			_this 				= this;
			_dialog_content		= _this.find(methods.settings.dialog_content);
			_overlay			= $(methods.settings.overlay);
			_dialog_wrapper 	= $(methods.settings.wrapper);
			_inner_wrapper 		= _dialog_wrapper.find(methods.settings.inner_wrapper);
			// get overlay selector
			// check if dialog content exists
			if( _dialog_content.length == 0 )
			{
				var dialog_wrapper = null;
				// check if wrapper exist
				if( _inner_wrapper.length == 0 || _dialog_wrapper.length == 0 )
				{
					// create elements
					_inner_wrapper = $('<div '+methods.get_selector(methods.settings.inner_wrapper)+'>');
					_dialog_wrapper = $('<div '+methods.get_selector(methods.settings.wrapper)+'>').html(_inner_wrapper.wrap('<div></div>').parents().html());
					dialog_wrapper = _dialog_wrapper.wrap('<div></div>').parents().html();
				}
				// ------------------
				// create dialog element
				_dialog_content = $('<div '+methods.get_selector(methods.settings.dialog_content)+'>').html(content);
				var dialog = '<div class="close">'+methods.settings.close_label+'</div>'+_dialog_content.wrap('<div></div>').parents().html();
				// check if object exists
				if( _this.length == 0 )
				{
					// if not
					_body.append( $(dialog_wrapper).find(methods.settings.inner_wrapper).html('<div '+methods.get_selector(_this.selector)+'>'+dialog+'</div>')
					.parents().add('<div '+methods.get_selector(methods.settings.overlay)+'></div>') );
					// reassign element
					_this = $(_this.selector);
					_overlay = $(methods.settings.overlay);
					_dialog_wrapper = $(methods.settings.wrapper);
					_inner_wrapper = _dialog_wrapper.find(methods.settings.inner_wrapper);
				}
				// if box exists
				else 
				{
					// if more than 1 dialog box, select first
					if( _this.length > 1 )
					{
						// reassign element to first dialog
						_this = _this.first();
					}
					// check if wrappers are needed
					if( dialog_wrapper != null )
					{
						var dialog = $(dialog_wrapper).find(methods.settings.inner_wrapper).html(_this.html(dialog)).parents();
						_body.append(dialog);
					}
					else
					{
						// add dialog content to box
						_this.html(dialog);
					}
					// check if dialog-overlay exists
					if( _overlay.length == 0 )
					{
						_overlay = _this.parents(methods.settings.wrapper).after('<div '+methods.get_selector(methods.settings.overlay)+'>');
					}
				}
				// reassign element
				_dialog_content		= _this.find(methods.settings.dialog_content);
			}
			// if content structure exists
			else
			{
				// replace
				_dialog_content.html(dialog);
				// check for overlay
				if( _overlay.length == 0 )
				{
					_overlay = _this.parents(methods.settings.wrapper).after('<div '+methods.get_selector(methods.settings.overlay)+'>');
				}
			}
			// add close events
			if( methods.settings.overlay_close === true )
			{
				_inner_wrapper.on('click', function(){
					methods.hide();
				}).children().on('click', function( e ){
					e.stopPropagation();
				});
			}
			$('.close').on('click', function(){
				methods.hide();
			});
			// add resize event
			$(window).fs_resize(function(){
				methods.position( true );
			});
	    },
		update: function(content, cache_name)
		{
			_dialog_content.html( content );
			// run function
			if( fn )
			{
				fn();
			}
			// reposition
			methods.position( true );
			// remove loading class
			_this.removeClass(methods.settings.loading);
			// set cache
			if( content != false && cache_name != null && cache_name != '' )
			{
				methods.cache[cache_name] = content;
			}
		},
		refresh: function( fn, args, cache_name )
		{
			if( typeof args === 'object' && methods.fn[fn] )
			{
				methods.cache[cache_name] = methods.fn[fn]( args, cache_name );
			}
			else
			{
				return false;
			}
		},
		// show dialog box
	    show: function( fn, args, cache_name, settings ) 
		{
			// reset content
			var content = '';
			// check for cache
			if( !methods.cache[cache_name] || methods.cache[cache_name] == null || args.refresh == true )
			{
				if( typeof args === 'object' && methods.fn[fn] )
				{
					methods.fn[fn]( args, cache_name );
				}
				else
				{
					var content = fn;
				}
			}
			// cache is available
			else
			{
				var content = methods.cache[cache_name];
			}
			// if dialog not initialized
			if( _this == null )
			{
				var arg = [ settings, content ];
				methods.init.apply(this, arg);
				// add loading class
				if( (!methods.cache[cache_name] || methods.cache[cache_name] == null || args.refresh == true) 
				&& typeof args === 'object' && methods.fn[fn] )
				{
					_this.addClass(methods.settings.loading);
				}
			}
			// if already initialized
			else
			{
				// add loading class
				if( (!methods.cache[cache_name] || methods.cache[cache_name] == null || args.refresh == true) 
				&& typeof args === 'object' && methods.fn[fn] )
				{
					_this.addClass(methods.settings.loading);
				}
				// replace content
				_dialog_content.html( content );
			}
			// show dialog wrapper
			_dialog_wrapper.show();
			// fadeIn background
			_overlay.fadeIn(methods.settings.overlay_speed);
			// set body overflow to hidden
			_body.css('overflow','hidden');
			// bring in dialog using the choosen fx
			methods.fx[methods.settings.fx]();
		},
		hide: function()
		{
			// hide overlay
			_overlay.fadeOut(methods.settings.speed_out);
			// hide dialog
			_this.fadeOut(methods.settings.speed_out, function(){
				_dialog_wrapper.hide();
			});
			// restore body overflow
			_body.css('overflow','auto');
		},
		position: function( animate )
		{
			var _window 			= $(window);
			var window_height 		= _window.height();
			var dialog_margin_top 	= _this.height()/2;
			var dialog_margin_left 	= _this.width()/2;
			//
			if( window_height < _this.height() + 20)
			{
				var inner_position = {'height': _this.height()+20};
			}
			else
			{
				var inner_position = {'height': window_height};
			}
			//
			if( window_height/2 < dialog_margin_top )
			{
				var position = {'top':10,'marginTop':0, 'left':'50%', 'marginLeft': -dialog_margin_left };
			}
			else
			{
				var position = {'marginTop':-dialog_margin_top, 'top': '50%', 'left':'50%', 'marginLeft': -dialog_margin_left};
			}
			if( animate == false || !animate)
			{
				_inner_wrapper.css(inner_position);
				_this.css(position);
			}
			else
			{
				_inner_wrapper.animate(inner_position, 500, methods.settings.easing);
				_this.animate(position, 500, methods.settings.easing);
			}
		},
		get_selector: function( selector )
		{
			// define vars
			var indicator 	= selector.charAt(0);
			var value 		= selector.substring(1);
			// check indicator
			if( indicator == '.')
			{
				selector = 'class="'+value+'"';	
			}
			else if( indicator == '#' )
			{
				selector = 'id="'+value+'"';	
			}
			// return selector
			return selector;
		}
	};
	
	$.fn.fs_dialog = function( method )
	{
		// Method calling logic
		if ( methods[method] ) 
		{
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} 
		else if ( typeof method === 'object' || ! method ) 
		{
			return methods.init.apply( this, arguments );
		}
		else
		{
			$.error( 'Method ' +  method + ' does not exist on jQuery.fs_dialog' );
		}
	}
	
	// default options
	$.fn.fs_dialog.defaults = {
		close_label: 		'close',
		fx: 				'slide',
		wrapper: 			'.dialog-wrapper',
		inner_wrapper: 		'.dialog-inner-wrapper',
		dialog_content: 	'.dialog-content',
		loading: 			'loading',
		overlay: 			'.dialog-overlay',
		overlay_close: 		true,
		speed: 				500,
		easing: 			'swing',
		speed_out: 			300,
		overlay_speed: 		500
	};
// add jquery to scope	
})( jQuery, window, document);
// ----------------------------------------------------
// once jquery is loaded and DOM is ready
$(function()
{
	// var cont = '<span>TESTöadsdfköalsdkfölasdkfölasdkfölasdkfölasdkfölasdkfölkasdfölkasdfölasdkflöasdkfölaskd</span><br /><br />incorp. easing fns<br /><br />test in ie<br /><br /><br />resize fn<br /><br /><br />transfer everything to settings<br /><br />Ask Anthony about DB types<br /><br /><br /><br /><br /><br /><br /><br /><br /><a href="vea.re" target="_blank">link</a>';
	// $('.user-card').click(function(){
	// 	$('.dialog').fs_dialog('show', 'ajax', {url:CI_BASE+'users/get_user_data', data:{ajax: 'test', 'username':'lukas'}, 'dataType':'text', 'refresh':true}, 'test', {'fx':'slide'});
	// 	// $('.dialog').fs_dialog('refresh', 'ajax', {url:CI_BASE+'ajax/get_user_data', data:{'username':'admin'}, 'dataType':'text'}, 'test');
	// });
	

	// $('.dialog').fs_dialog('position');
});