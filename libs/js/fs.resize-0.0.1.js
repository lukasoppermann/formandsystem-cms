// ----------------------------------------------------
// Base functions used in all or many files
// ----------------------------------------------------
// define functions 
;(function( $, window, document )
{
	// ----------------------------------------------------
	// debounced resize event (fires once every 100ms)
	$.fn.fs_resize = function( c, t )
	{
		onresize = function(){
			clearTimeout( t );
			t = setTimeout( c, 100)
		};
		return c;
	};	
	// ----------------------------------------------------
// add jquery to scope	
})( jQuery, window, document);