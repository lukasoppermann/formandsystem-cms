$(function(){
	// once jquery is loaded
	var _body 		= $('body');
	// --------------------------------------------------------------------
	var _input_user 		= $('#username');
	var _show_user			= $('#show_forgot_user');
	var _forgot_user 		= $('#forgot_user');
	var _forgot_password 	= $('#forgot_password');
	var _retrieve_password 	= $('#retrieve_password')
	// --------------------------------------------------------------------
	// show user retrieve window on click
	_show_user.on('click', function(){
		if(_forgot_user.hasClass('hidden'))
		{
			_forgot_password.fadeOut(200);
			_forgot_user.css({'right':'+=30','opacity':'0'}).removeClass('hidden').animate({'right':'-=30','opacity':'1.0'});
		}
		else
		{
			_forgot_user.fadeOut(300, function(){
				_forgot_user.addClass('hidden').show();
			});			
		}
	});
	// --------------------------------------------------------------------
	// Password retrieve ajax
	_retrieve_password.on('click', function(){
		$.ajax({
			url: CI_BASE+'ajax/user/retrieve/password',
			data: {'user':_input_user.val()},
			dataType: 'text',
			type: 'POST',
			success: function(response){
				var _content = _forgot_password.find('.bubble-content');
				var text = _content.html();
				_content.animate({'opacity':0}, 300, function(){
					_content.text(response).animate({'opacity':1}, 300, function(){
						setTimeout(function(){
							_forgot_password.fadeOut(300);
						}, 10000);
					});
				});
			},
		});
		return false;
	});
	// --------------------------------------------------------------------
	// hide ? on user input
	if(_input_user.val() != '')
	{
		_show_user.fadeOut();	
	}
	//
	_body.on('keyup', '#username', function(){
		if(_input_user.val() == '')
		{
			_show_user.fadeIn();
		}
		else
		{
			_show_user.fadeOut();
		}
	});
	_body.on('blur', '#username', function(){
		if(_input_user.val() == '')
		{
			_show_user.fadeIn();
		}
	});
	// --------------------------------------------------------------------
	var _input_password 	= $('#password');
	var _show_password 		= $('#show_password');
	// --------------------------------------------------------------------
	// show password visibility icon
	if(_input_password.val() != '')
	{
		_show_password.fadeIn();	
	}
	//
	_body.on('keyup', '#password', function(){
		if(_input_password.val() == '')
		{
			_show_password.fadeOut();
		}
		else
		{
			_show_password.fadeIn();
		}
	});
	_body.on('blur', '#password', function(){
		if(_input_password.val() == '')
		{
			_show_password.fadeOut();
		}
	});
	// --------------------------------------------------------------------
	// show / hide password
	_body.on('click', '#show_password', function()
	{
		var _clear		= $('#password_clear');
		var password 	= null;
		//
		if( !_show_password.hasClass('active') )
		{
			password = _input_password.val();
			_show_password.addClass('active invisible').removeClass('visible');
			_clear.val(password).removeClass('hidden');
		}
		else
		{
			password = _clear.val();
			_show_password.removeClass('active invisible').addClass('visible');
			_input_password.val(password);
			_clear.addClass('hidden');
		}
	});
	// update password field from real text
	_body.on('keydown', '#password_clear', function()
	{
		_input_password.val($(this).val());
	});
// end of jquery area
});