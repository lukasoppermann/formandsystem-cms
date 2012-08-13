// ----------------------------------------------------
// Base functions used in all or many files
// ----------------------------------------------------
// define functions 
function pulse(elem, duration, easing, prop_from, prop_to, until)
{
	elem.animate(prop_to, duration, easing, function(){
		if( until() == false )
		{
			pulse(elem, duration, easing, prop_to, prop_from, until);	
		}
	});	
}

$('#loader').css({'bottom':'50%', 'left':'-120%'}).animate({'left':'50%', 'opacity':1}, 750, 'swing', function(){
	$('#loader').find('.form').css({'left':'+=50'}).animate({'opacity':0.8, 'left' : '-=40' }, 400, function(){
		$('#loader').find('.form').animate({'opacity':1, 'left' : '-=10' }, 100);
		$('#loader').find('.system').css({'left':'+=50'}).animate({'opacity':1, 'left' : '-=50' }, 500, function(){
			setTimeout(function(){
				pulse($('#loader'), 1800, 'swing', {'opacity':1}, {'opacity':0.5}, function(){if(!$('#loader').hasClass('done')){return false;}});
				setTimeout(function(){
					$('#loader').addClass('done');
					$('#loader').animate({'bottom':'-120%','opacity':0}, 600, function(){
						$('#header').animate({'marginTop':0}, 300);
						$('#content').fadeIn();
					});
				}, 10000);
			}, 1500);
		});
	});
});
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
			_window.fs_resize(function(){
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
		// check if element is visible
		// if( display none) make visibility hidden, get offset, hide
		
		// define vars
		var offset 			= _this.offset();
		var final_position	= new Array();
		// check positions
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
	// debounced resize event (fires once every 100ms)
	$.fn.fs_resize = function( c, t )
	{
		onresize = function(){
			clearTimeout( t );
			t = setTimeout( c, 100);
		};
		return c;
	};	
	// ----------------------------------------------------
// add jquery to scope	
})( jQuery, window, document);
// ----------------------------------------------------
// once jquery is loaded and DOM is ready
$(function()
{

});