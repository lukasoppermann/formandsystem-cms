// ----------------------------------------------------
// Base functions used in all or many files
// ----------------------------------------------------
// define functions 
;(function( $, window, document )
{
	// ----------------------------------------------------
	// center element
	$.fn.fs_center = function ()
	{
		// return element for chaining
		return this.each(function()
		{
			// cache selection
			var _this = $(this);
			var _window = $(window);
			// initial set position
			_this.css({'left':'50%', 'top':'50%', 'marginLeft':-_this.outerWidth()/2, 'marginTop':-_this.outerHeight()/2});
			// on load reajust position if nessesary
			_window.load(function(){
				_this.animate({'marginLeft':-_this.outerWidth()/2, 'marginTop':-_this.outerHeight()/2}, 200);
			});
			// adjust position on resize
			_window.resize(function(){
				_this.css({'marginLeft':-(_this.outerWidth()/2), 'marginTop':-_this.outerHeight()/2});	
			});
		});
	};
	// ----------------------------------------------------
	// set focus
	$.fn.fs_focus = function ()
	{
		// return element for chaining
		return this.each(function()
		{
			// cache selection
			var _this = $(this);
			// set focus and assign value to element to set focus to end
			_this.focus().val( _this.val() );
		});
	}
	// ----------------------------------------------------
	// find position
	$.fn.fs_position = function ( options )
	{
		// define positions
		var defaults = {
	    	position: 			'left',
	    	positions: 			["left","right","top","bottom"]
	  	};
	  	// Extend default options with those provided
		var opts = $.extend({}, defaults, options);
		// cache selections
		var _this 			= this;
		var _window			= $(window);
		// define vars
		var offset 			= _this.offset();
		var final_position	= new Array();
		// check positions
			console.log(opts);
		// left	
		if( $.inArray('left', opts.positions) != -1 && offset['left'] > _this.outerWidth()+10 )
		{
			if( opts.position == 'left' )
			{
				return 'left';
			}
			final_position.push('left');
		}
		// right
		if( $.inArray('right', opts.positions) != -1 && offset['left'] < _window.width()-(_this.outerWidth()+10) )
		{
			if( opts.position == 'right' )
			{
				return 'right';
			}
			final_position.push('right');
		}
		// top
		if( $.inArray('top', opts.positions) != -1 && offset['top'] < -(_this.outerHeight()+10) )
		{
			if( opts.position == 'top' )
			{
				return 'top';
			}
			final_position.push('top');
		}
		// bottom
		if( $.inArray('bottom', opts.positions) != -1 && offset['top'] > -(_window.height()-(_this.outerHeight()+10)) )
		{
			if( opts.position == 'bottom' )
			{
				return 'bottom';
			}
			final_position.push('bottom');
		}
		// define output variable 
		var position;
		$.each(opts.positions, function(i, pos)
		{
			if( $.inArray(pos, final_position) != -1 )
			{
				position = pos;
				return false;
			}
		});
		// return output
		return position;
	}	
	// ----------------------------------------------------
// add jquery to scope	
})( jQuery, window, document);
// ----------------------------------------------------
// once jquery is loaded and DOM is ready
$(function()
{
		
});