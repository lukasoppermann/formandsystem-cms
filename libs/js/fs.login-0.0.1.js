$(function(){
	// once jquery is loaded
	// --------------------------------------------------------------------
	var _wrapper 			= $('#login');
	var _input_user 		= $('#username');
	var _input_password 	= $('#password');
	var _btn_show_password 	= $('#show_password');
	var _btn_show_user		= $('#show_forgot_user');
	
	var _forgot_user_bubble	= $('#forgot_user_bubble');
	var _forgot_password 	= $('#forgot_password');
	var _retrieve_password 	= $('#retrieve_password');
	var _user_blocked		= $('#user_blocked');
	// --------------------------------------------------------------------
	// show user retrieve window on click
	_btn_show_user.on('click', function()
	{
		if(_forgot_user_bubble.hasClass('hidden'))
		{
			_forgot_password.fadeOut(200);
			_forgot_user_bubble.css({'right':'+=30','opacity':'0'}).removeClass('hidden').animate({'right':'-=30','opacity':'1.0'});
		}
		else
		{
			_forgot_user_bubble.fadeOut(300, function(){
				_forgot_user_bubble.addClass('hidden').show();
			});			
		}
	});
	// --------------------------------------------------------------------
	// Password retrieve ajax
	// _retrieve_password.on('click', function(){
	// 	$.ajax({
	// 		url: CI_BASE+'ajax/user/retrieve/password',
	// 		data: {'user':_input_user.val()},
	// 		dataType: 'text',
	// 		type: 'POST',
	// 		success: function(response){
	// 			bubble_response( _forgot_password, response );
	// 		},
	// 	});
	// 	return false;
	// });
	// // --------------------------------------------------------------------
	// // User blocked ajax
	// var _user_link_blocked = null;
	// _user_blocked.on('click', function()
	// {	
	// 	if(_user_link_blocked == null )
	// 	{
	// 		_user_link_blocked = true;
	// 		// ajax call
	// 		$.ajax({
	// 			url: CI_BASE+'ajax/user/retrieve/user_blocked',
	// 			data: {'user':_input_user.val()},
	// 			dataType: 'text',
	// 			type: 'POST',
	// 			success: function(response){
	// 				bubble_response( blocked_user, response );
	// 				_user_link_blocked = null;
	// 			},
	// 		});
	// 	}
	// 	return false;
	// });
	// --------------------------------------
	// fn for bubble link events
	var retrieval_pending = null;
	_wrapper.on('click', '.retrieval-link', function()
	{
		var _this = $(this);
		var user = _wrapper.find('#'+_this.data('post')).val();
		console.log(retrieval_pending);
		// check if retrival is pending
		if(retrieval_pending == null && user != null && user != "")
		{
			// set retrival to pending
			retrieval_pending = true;
			// make ajax call
			$.ajax({
				url: CI_BASE+'ajax/user/retrieve/'+_this.data('url'),
				data: {'user':user},
				dataType: 'json',
				type: 'POST',
				success: function(response)
				{
					bubble_response( _this.parents('.bubble'), response.message );
					// set retrival to NOT pending
					retrieval_pending = null;
				},
			});
		}
		// return false / no link behavior
		return false;
	});
	// --------------------------------------
	// fn for bubble response
	function bubble_response( bubble, response )
	{
		// get vars
		var _content 	= bubble.find('.bubble-content');
		var text 		= _content.html();
		// animate bubble
		_content.animate({'opacity':0}, 200, function(){
			_content.text(response).animate({'opacity':1}, 200, function(){
				setTimeout(function(){
					bubble.fadeOut(300, function(){
						_content.html(text);
					});
				}, 10000);
			});
		});
	}
	// --------------------------------------------------------------------
	// hide ? on user input
	if(_input_user.val() != '')
	{
		_btn_show_user.fadeOut();	
	}
	//
	_wrapper.on('keyup', '#username', function(){
		if(_input_user.val() == '')
		{
			_btn_show_user.fadeIn();
		}
		else
		{
			_btn_show_user.fadeOut();
		}
	});
	_wrapper.on('blur', '#username', function(){
		if(_input_user.val() == '')
		{
			_show_user.fadeIn();
		}
	});
	// // --------------------------------------------------------------------
	// 
	// // --------------------------------------------------------------------
	// // show password visibility icon
	// if(_input_password.val() != '')
	// {
	// 	_show_password.fadeIn();	
	// }
	// //
	// _wrapper.on('keyup', '#password', function(){
	// 	if(_input_password.val() == '')
	// 	{
	// 		_show_password.fadeOut();
	// 	}
	// 	else
	// 	{
	// 		_show_password.fadeIn();
	// 	}
	// });
	// _wrapper.on('blur', '#password', function(){
	// 	if(_input_password.val() == '')
	// 	{
	// 		_show_password.fadeOut();
	// 	}
	// });
	// // --------------------------------------------------------------------
	// // show / hide password
	// _wrapper.on('click', '#show_password', function()
	// {
	// 	var _clear		= $('#password_clear');
	// 	var password 	= null;
	// 	//
	// 	if( !_show_password.hasClass('active') )
	// 	{
	// 		password = _input_password.val();
	// 		_show_password.addClass('active invisible').removeClass('visible');
	// 		_clear.val(password).removeClass('hidden');
	// 	}
	// 	else
	// 	{
	// 		password = _clear.val();
	// 		_show_password.removeClass('active invisible').addClass('visible');
	// 		_input_password.val(password);
	// 		_clear.addClass('hidden');
	// 	}
	// });
	// // update password field from real text
	// _wrapper.on('keydown', '#password_clear', function()
	// {
	// 	_input_password.val($(this).val());
	// });
// end of jquery area
});