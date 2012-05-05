// --------------------------------------------------------------------
// test for local storage
function supports_local_storage() 
{
	try{
    	return 'localStorage' in window && window['localStorage'] !== null;
  	}
	catch( e )
	{
    	return false;
  	}
}
// --------------------------------------------------------------------
// save data to local storage
function store_local( )
{
	localStorage
}
// --------------------------------------------------------------------
// get data from local storage
function get_local( )
{
	
}