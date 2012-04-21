$(function(){
	// once jquery is loaded
	// --------------------------------------------------------------------
	// add class 'empty' to element if empty on blur, else remove
	$('body').on('blur', 'input', function()
	{
		var _input = $(this);
		// check if value is empty
		if(_input.val() == '')
		{
			_input.addClass('empty');
		}
		else
		{
			_input.removeClass('empty');
		}
	});
	// --------------------------------------------------------------------
});