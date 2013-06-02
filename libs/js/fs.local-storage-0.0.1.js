( function( $ ){
	// --------------------------------------------------------------------
	// test for local storage
	var supports_local_storage = function() 
	{
		try{
	    	return 'localStorage' in window && window['localStorage'] !== null;
	  	}
		catch( e )
		{
	    	return false;
	  	}
	};
	// --------------------------------------------------------------------
	// save data to local storage
	$.store_local = function( key, string, json )
	{
		// check for localStorage support
	    if( !supports_local_storage() ) 
		{ 
			// if no localStorage support
			return false; 
		}
		// if localStorage is supported
		else
		{
			// check for json
			if( json === true )
			{
				localStorage[key] = JSON.stringify(string);
			}
			else
			{
				localStorage[key] = string;
			}
		}
	};
	// --------------------------------------------------------------------
	// update json data in local storage
	$.update_local = function( key, name, json)
	{
		// check for localStorage support
	    if( !supports_local_storage() ) 
		{ 
			// if no localStorage support
			return false; 
		}
		// if localStorage is supported
		else
		{
			var obj = JSON.parse( localStorage.getItem(key) );
			//
			if( obj === undefined || obj === null )
			{
				var obj = {};
				obj[name] = json;
			}
			else
			{
				obj[name] = json;
			}
			//
			localStorage[key] = JSON.stringify(obj);
		}
	};
	// --------------------------------------------------------------------
	// get data from local storage
	$.get_local = function( key, json)
	{
		// check for localStorage support
	    if( !supports_local_storage() ) 
		{ 
			// if no localStorage support
			return false; 
		}
		// if localStorage is supported
		else
		{
			// check if data is stored
			if( !localStorage[key] )
			{
				// if not, return false
				return false;
			}
			else
			{
				// check for json
				if( json === true )
				{
					return JSON.parse( localStorage[key] );
				}
				else
				{
					// return string
					return localStorage[key];
				}
			}
		}
	}
})( jQuery );