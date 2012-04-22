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
			_input.parents('.form-element').addClass('empty');
		}
		else
		{
			_input.parents('.form-element').removeClass('empty');
		}
	});
	// --------------------------------------------------------------------
	// show / hide password
	$('body').on('click', '#show_password', function()
	{
		var _this		= $(this);
		var _input 		= $('#password');
		var _clear		= $('#password_clear');
		var password 	= null;
		//
		if( !_this.hasClass('active') )
		{
			password = _input.val();
			_this.addClass('active');
			_clear.val(password).removeClass('hidden');
		}
		else
		{
			password = _clear.val();
			_this.removeClass('active');
			_input.val(password);
			_clear.addClass('hidden');
		}
	});
	// update password field from real text
	$('body').on('keydown', '#password_clear', function()
	{
		$('#password').val($(this).val());
	});
});