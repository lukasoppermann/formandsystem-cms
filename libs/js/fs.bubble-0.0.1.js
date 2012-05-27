// // ----------------------------------------------------
// // Bubble Class
// // ----------------------------------------------------
// // define class
// ;(function( $, window )
// {
// 		// default options
// 		var defaults = {
// 	    	position: 			'left',
// 	    	force_position: 	false
// 	  	};
// 	  	// Extend default options with those provided
// 		var opts = $.extend({}, $.fn.fs_bubble.defaults, options);
// 		// methids
// 		var methods = {
// 		    init : function( options ) 
// 			{ 
// 				return this.each(function()
// 				{
// 					// cache selections
// 					var _this 			= $(this);
// 					var _window			= $(window);
// 					// call position
// 					var position = methods.position.apply( this );
// 				}
// 		    },
// 		    position : function( _window ) 
// 			{
// 				var _this			= $(this);
// 				var offset 			= _this.offset();
// 				// check for force positioning
// 				if( defaults.force_position !== true )
// 				{
// 					return find_position(false, defaults.position);
// 				}
// 				else
// 				{
// 					return defaults.force_position;
// 				}
// 			}
// 		};
// 		
// 		$.fn.fs_bubble = function( method )
// 		{
// 			// Method calling logic
// 			if ( methods[method] ) 
// 			{
// 				return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
// 			} 
// 			else if ( typeof method === 'object' || ! method ) 
// 			{
// 				return methods.init.apply( this, arguments );
// 			}
// 			else
// 			{
// 				$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
// 			}
// 		}
// 
// 				find_position = function( position = false, new_position )
// 				{
// 					if( new_position == 'left' )
// 					{
// 						if( offset[new_position] < _this.outerWidth()+10)
// 						{
// 							new_position = 'right';
// 						}
// 						else
// 						{
// 							position = true;
// 						}
// 					}
// 					else if( new_position == 'right' )
// 					{
// 						if( offset[new_position] > _window.width()-(_this.outerWidth()+10) )
// 						{
// 							new_position = 'top';
// 						}
// 						else
// 						{
// 							position = true;
// 						}
// 					}
// 					else if( new_position == 'top' )
// 					{
// 						if( offset[new_position] < _this.outerHeight()+10 )
// 						{
// 							new_position = 'bottom';
// 						}
// 						else
// 						{
// 							position = true;
// 						}
// 					}
// 					else if( new_position == 'bottom' )
// 					{
// 						if( offset[new_position] > _window.height()-(_this.outerHeight()+10) )
// 						{
// 							new_position = 'left';
// 						}
// 						else
// 						{
// 							position = true;
// 						}
// 					}
// 					// check position
// 					if( position === true)
// 					{
// 						return new_position;
// 					}
// 					else
// 					{
// 						find_position(false, new_position)
// 					}
// 				}
// 
// 	  // $.fn.tooltip = function( method ) {
// 	  // 
// 	  // 	    // Method calling logic
// 	  // 	    if ( methods[method] ) {
// 	  // 	      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
// 	  // 	    } else if ( typeof method === 'object' || ! method ) {
// 	  // 	      return methods.init.apply( this, arguments );
// 	  // 	    } else {
// 	  // 	      $.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
// 	  // 	    }    
// 	  // 
// 	  // 	  };
// 	
// 	// ---------------------------
// 	// fn bubble
// 	// function bubble( bubble, hide )
// 	// {
// 	// 	if( hide == null )
// 	// 	{
// 	// 		if( bubble.hasClass('hidden') )
// 	// 		{
// 	// 			bubble.css({'right':'+=35','opacity':'0'}).show().removeClass('hidden').animate({'right':'-=35','opacity':'1.0'});
// 	// 		}
// 	// 		else
// 	// 		{
// 	// 			bubble.animate({'opacity':'0'}, function(){
// 	// 				bubble.addClass('hidden').show();
// 	// 			});
// 	// 		}
// 	// 	}
// 	// 	else if( hide === true )
// 	// 	{
// 	// 		bubble.animate({'opacity':'0'}, function(){
// 	// 			bubble.addClass('hidden');
// 	// 		});
// 	// 	}
// 	// 	else if( hide === 'show' )
// 	// 	{
// 	// 		if( bubble.hasClass('hidden') )
// 	// 		{
// 	// 			bubble.css({'right':'+=35','opacity':'0'}).show().removeClass('hidden').animate({'right':'-=35','opacity':'1.0'});
// 	// 		}
// 	// 	}
// 	// }
// 	// // --------------------------------------
// 	// // fn for bubble response
// 	// function bubble_response( bubble, height, response )
// 	// {
// 	// 	// get vars
// 	// 	var _content 	= bubble.find('.bubble-content');
// 	// 	var text 		= _content.html();
// 	// 	// animate bubble
// 	// 	_content.animate({'opacity':0}, 200, function(){
// 	// 		_content.text(response.message).animate({'opacity':1}, 200, function()
// 	// 		{
// 	// 			if(response.success == true)
// 	// 			{
// 	// 				setTimeout(function()
// 	// 				{
// 	// 					bubble.fadeOut(300, function(){
// 	// 						_content.html(text);
// 	// 						bubble.css({'top': '+=' + ( (height - bubble.height()) / 2 )}).addClass('hidden');
// 	// 					});
// 	// 				}, 10000);
// 	// 			}
// 	// 			else
// 	// 			{
// 	// 				setTimeout(function()
// 	// 				{
// 	// 					bubble.fadeOut(300, function(){
// 	// 						_content.html(text);
// 	// 						bubble.css({'top': '+=' + ( (height - bubble.height()) / 2 )}).fadeIn(300);
// 	// 					});
// 	// 				}, 3000);
// 	// 			}
// 	// 		});
// 	// 		// animate bubble position
// 	// 		bubble.css({'top': '+=' + ( (height - bubble.height()) / 2 )});
// 	// 		height = bubble.height();
// 	// 	});	
// 	// }
// // add jquery to scope
// })( jQuery, window );