$(function(){
	// once jquery is loaded
	// --------------------------------------------------------------------
	var _wrapper 					= $('#login');
	var _widget 					= $('.widget');
	var _active_users 				= $('.active-user');
	var _new_user					= $('.login');
	// inputs
	var _input_user 				= _new_user.find('.user');
	var _input_password 			= $('.password');
	var _input_password_clear		= $('.password-clear');
	var _input_full_name			= $('.full_name');
	// buttons
	var _btn_show_password 			= $('.show-password');
	var _btn_show_user				= $('#show_forgot_user');
	// buttons
	var _forgot_user_bubble			= $('#forgot_user_bubble');
	var _forgot_password_bubble 	= $('#forgot_password_bubble');
	// links
	var _retrieve_password 			= $('#retrieve_password');
	var _user_blocked				= $('#user_blocked');
	// given information
	var given_user					= null;
	var	timer_user					= null;
	var	user_image_class			= 'cms-profile';
	// --------------------------------------------------------------------
	// move login box to center	
	_wrapper.css({'marginLeft':-_wrapper.width()/2, 'marginTop':-(_wrapper.height()/2)-50});
	// --------------------------------------------------------------------
	// submit form ajax
	_wrapper.on('submit', function(e)
	{
		var _active = _wrapper.find('.active');
		// submit form via ajax
		$.ajax({
			url: CI_BASE+'ajax/user/login/',
			data: {'user':_active.find('.user').val(), 'password':_active.find('.password').val()},
			dataType: 'json',
			type: 'POST',
			success: function(response)
			{
				console.log(response);
			}
		});
		// return false
		return false;
	});
	// --------------------------------------------------------------------
	// show user retrieve window on click
	_btn_show_user.on('click', function()
	{
		// if bubble is hidden
		if(_forgot_user_bubble.hasClass('hidden'))
		{
			// hide password bubble
			_forgot_password_bubble.fadeOut(200);
			// show user bubble
			_forgot_user_bubble.css({'right':'+=40','opacity':'0'}).removeClass('hidden').animate({'right':'-=35','opacity':'1.0'});
		}
		// if bubble is visible
		else
		{
			// hide user bubble
			_forgot_user_bubble.fadeOut(300, function()
			{
				_forgot_user_bubble.addClass('hidden').show();
			});			
		}
	});
	// --------------------------------------
	// fn for bubble link events
	var retrieval_pending = null;
	_wrapper.on('click', '.retrieval-link', function()
	{
		var _this = $(this);
		var user = _wrapper.find('#'+_this.data('post')).val();
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
					var bubble = _this.parents('.bubble');
					bubble_response( bubble, height = bubble.height(), response );
					// set retrival to NOT pending
					retrieval_pending = null;
				}
			});
		}
		// return false / no link behavior
		return false;
	});
	// --------------------------------------
	// fn for bubble response
	function bubble_response( bubble, height, response )
	{
		// get vars
		var _content 	= bubble.find('.bubble-content');
		var text 		= _content.html();
		// animate bubble
		_content.animate({'opacity':0}, 200, function(){
			_content.text(response.message).animate({'opacity':1}, 200, function()
			{
				if(response.success == true)
				{
					setTimeout(function()
					{
						bubble.fadeOut(300, function(){
							_content.html(text);
							bubble.css({'top': '+=' + ( (height - bubble.height()) / 2 )});
						});
					}, 10000);
				}
				else
				{
					setTimeout(function()
					{
						bubble.fadeOut(300, function(){
							_content.html(text);
							bubble.css({'top': '+=' + ( (height - bubble.height()) / 2 )}).fadeIn(300);
						});
					}, 3000);
				}
			});
			// animate bubble position
			bubble.css({'top': '+=' + ( (height - bubble.height()) / 2 )});
			height = bubble.height();
		});
	}
	// --------------------------------------------------------------------
	// hide ? on user input
	if(_new_user.find('.user').val() != '')
	{
		// hide user button if input is not empty
		_btn_show_user.animate({'opacity':0}, 100, function()
		{
			_btn_show_user.hide();
		});
	}
	// on typing into username field
	_input_user.on('keyup', function()
	{
		// if input is empty
		if(_input_user.val() == '')
		{
			// fadein button
			_btn_show_user.show().animate({'opacity':0.4}, 300);
		}
		// if input not empty
		else
		{
			// fadeout button
			_btn_show_user.animate({'opacity':0}, 300, function()
			{
				_btn_show_user.hide();
			});
		}
	});
	// on blur of username field
	_input_user.on('blur', function()
	{
		// if input is empty
		if(_input_user.val() == '')
		{
			// fadein button
			_btn_show_user.show().animate({'opacity':0.4}, 300);
		}
	});
	// --------------------------------------------------------------------
	// show/hide show password icon
	// --------------------
	// typing into password field
	_input_password.on('keyup', function()
	{
		// assing variables
		var _input_password = $(this);
		var _btn_show_password = _input_password.siblings('.show-password');
		// if field is emtpy
		if(_input_password.val() == '')
		{
			// fade out button
			_btn_show_password.animate({'opacity':0.0}, 300, function()
			{
				_btn_show_password.hide();
			});
		}
		// if field is full
		else
		{
			// fade in button
			_btn_show_password.show().animate({'opacity':0.4}, 300);
		}
	});
	// --------------------
	// on blur password field
	_input_password.on('blur', function()
	{
		// assing variables
		var _input_password 			= $(this);
		var _btn_show_password 			= _input_password.siblings('.show-password');		
		// if password field is empty
		if(_input_password.val() == '' && _btn_show_password.css('opacity') != 0)
		{
			// fade password button
			_btn_show_password.animate({'opacity':0.0}, 300, function()
			{
				_btn_show_password.hide();
			});
		}
	});
	// on blur password clear field
	_input_password_clear.on('blur', function()
	{
		// assing variables
		var _input_password_clear 		= $(this);
		var _btn_show_password 			= _input_password.siblings('.show-password');
		// if password field is empty
		if(_input_password_clear.val() == '' && _btn_show_password.css('opacity') != 0)
		{
			// fade password button
			_btn_show_password.animate({'opacity':0.0}, 300, function()
			{
				// hide password clear field 
				_input_password_clear.addClass('hidden');
				// reset password show button
				_btn_show_password.hide().removeClass('active invisible').addClass('visible');
			});
		}
	});
	// --------------------------------------------------------------------
	// show / hide password clear text
	_btn_show_password.on('click', function()
	{
		// assing variables
		var _btn_show_password 			= $(this);
		var _input_password_clear 		= _btn_show_password.siblings('.password-clear');
		var _input_password				= _btn_show_password.siblings('.password');
		// if clear password is not active
		if( !_btn_show_password.hasClass('active') )
		{
			// set button to "invisible" [icon] 
			_btn_show_password.addClass('active invisible').removeClass('visible');
			// assign password content to clear text field, and show
			_input_password_clear.val( _input_password.val() ).removeClass('hidden');
		}
		// if clear password is active
		else
		{
			// set button to "visible" [icon] 
			_btn_show_password.removeClass('active invisible').addClass('visible');
			// update real password field
			_input_password.val( _input_password_clear.val() );
			// hide clear password field
			_input_password_clear.addClass('hidden');
		}
	});
	// if typing in clear password field
	_input_password_clear.on('keyup', function()
	{
		// assing variables
		var _input_password_clear 			= $(this);
		// update real password field
		_input_password_clear.siblings('.password').val( _input_password_clear.val() );
	});
	// --------------------------------------------------------------------
	// user full name enter	
	_forgot_user_bubble.on('keydown', _input_full_name, function(e)
	{
		// grab pressed key
		var keycode = (e.keyCode ? e.keyCode : e.which);		
		// if pressed key == return
		if(keycode == '13')
		{
			e.preventDefault();
			$("#retrieve_user_link").click();
		}
	});
	// --------------------------------------------------------------------
	// get user name & image
	// on blur of user name field
	_input_user.on('blur', function()
	{
		get_user_data( $(this).parents('.widget') );
	});
	// on key up in user field
	_input_user.on('keyup', function()
	{
		// clear out the old timer
		clearTimeout(timer_user);
		// set a new timer to 1.5 seconds
		timer_user = setTimeout(function()
		{
			// if user idle for 1.5 seconds request new data
			get_user_data( $(this).parents('.widget') );
		}, 1300);
	});
	// ---------------------------
	// fn get user data
	function get_user_data( widget )
	{
		// check if user-name/email has changed since last request
		if( given_user != _input_user.val() )
		{
			var _user_name 				= widget.find('.fullname');
			var _user_image_wrapper		= widget.find('.user-image');
			var _user_image				= _user_image_wrapper.find('.profile-image');

			// set given user name or email
			given_user = _input_user.val();
			// get user information form database
			$.ajax({
				url: CI_BASE+'ajax/user/get',
				data: {'user': given_user},
				dataType: 'json',
				type: 'POST',
				success: function(response)
				{
					// if users full name differs from current name
					if( _user_name.text() !== response.username )
					{
						// fade out current name
						_user_name.fadeOut(100, function()
						{
							// change to new name and fade in
							_user_name.text( response.username ).fadeIn(300);
						});
						// change user image if it exists
						if( response.user_image != null)
						{
							_user_image.fadeOut(100, function()
							{ 
								if(response.class != undefined)
								{
									_user_image_wrapper.removeClass(user_image_class).addClass(response.class);
									user_image_class = response.class;
								}
								else
								{
									_user_image_wrapper.removeClass(user_image_class);
									user_image_class = null;
								}
								_user_image.attr('src', response.user_image).fadeIn();
							});
						}
					}
				},
			});
		}
	}
	// --------------------------------------------------------------------
	// add click event to active user cards
	_active_users.on('mousedown', function()
	{	
		// get clicked widget	
		var _this_widget = $(this).find('.widget');
		// check if widget is not active
		if( !_this_widget.hasClass('active') )
		{
			// expand user widget
			expand_user(_this_widget);
			// contract active user
			contract_user(_active_users.find('.active'));
			contract_new_user(_new_user);
		}
		else
		{	
			setTimeout(function()
			{
				_this_widget.find('.password').select();
				_this_widget.find('.password-clear').select();
			}, 100);
		}
	});
	// ---------------------------
	// fn contract user
	function contract_user( widget )
	{
		// define variables
		var password = widget.find('.form-element');
		// contract widget
		widget.animate({'width': '200', 'height': '200', 'marginTop': '-100', 'marginLeft': '-100'}, 250, 'easeInOutQuart', function()
		{
			// remove class 'active'
			widget.removeClass('active');
		});
		// contract widget-content and remove padding
		widget.find('.widget-content').animate({'height': '190', 'width':'190', 'padding': '0'}, 250, 'easeInOutQuart');
		widget.find('.user-image').animate({'height':'180', 'width':'180'}, 250, 'easeInOutQuart');
		// slide away password input
		password.animate({'marginTop': '-35'}, 250, 'easeInOutQuart', function()
		{
			// display none password input
			password.css({'display':'none'});
		});
	}
	// ---------------------------
	// fn expand user
	function expand_user( widget )
	{
		// expand widget
		widget.animate({'width': '290', 'height': '350', 'marginTop': '-160', 'marginLeft': '-145'}, 250, 'easeInOutQuart', function()
		{
			// add class 'active'
			widget.addClass('active');
		});
		// expand widget content
		widget.find('.widget-content').animate({'height':'300', 'width':'260', 'padding': '5'}, 250, 'easeInOutQuart');
		widget.find('.user-image').animate({'height':'250', 'width':'250'}, 250, 'easeInOutQuart');
		// slide in password input
		widget.find('.form-element').css({'display':'block'}).delay(50).animate({'marginTop': 5}, 160, 'easeInOutQuart', function(){
			$(this).find('.password').select();
			$(this).find('.password-clear').select();
		});
	}
	// --------------------------------------------------------------------
	// add click event to new user cards
	_new_user.on('mousedown', function()
	{	
		// get clicked widget	
		var _this_widget = $(this);
		// check if widget is not active
		if( !_this_widget.hasClass('active') )
		{
			// expand user widget
			expand_new_user(_this_widget);
			// contract active user
			contract_user(_active_users.find('.active'));
		}
		else
		{	
			setTimeout(function()
			{
				_this_widget.find('.user').select();
			}, 100);
		}
	});
	// ---------------------------
	// fn contract new user
	function contract_new_user( widget )
	{
		// only run if widget is active
		if( widget.hasClass('active') )
		{
			// define variables
			var password = widget.find('.form-element');
			// contract widget
			widget.animate({'width': '200', 'height': '200', 'marginTop': '-100', 'marginLeft': '-100'}, 250, 'easeInOutQuart', function()
			{
				// remove class 'active'
				widget.removeClass('active');
			});
			// contract widget-content and remove padding
			widget.find('.widget-content').animate({'height': '190', 'width':'190', 'padding': '0'}, 250, 'easeInOutQuart');
			widget.find('.user-image').animate({'height':'180', 'width':'180'}, 250, 'easeInOutQuart');
			// slide away password input
			password.animate({'marginTop': '-35'}, 250, 'easeInOutQuart', function()
			{
				// display none password input
				password.css({'display':'none'});
			});
		}
	}
	// ---------------------------
	// fn expand new user
	function expand_new_user( widget )
	{
		// expand widget
		widget.animate({'width': '290', 'height': '370', 'marginTop': '-160', 'marginLeft': '-145'}, 250, 'easeInOutQuart', function()
		{
			// add class 'active'
			widget.addClass('active');
		});
		// expand widget content
		widget.find('.widget-content').animate({'height':'340', 'width':'260', 'padding': '5'}, 250, 'easeInOutQuart');
		widget.find('.user-image').animate({'height':'250', 'width':'250'}, 250, 'easeInOutQuart');
		// slide in password input
		widget.find('.form-element').css({'display':'block'}).delay(50).animate({'marginTop': 5}, 160, 'easeInOutQuart', function(){
			$(this).find('.user').select();
		});
	}
// --------------------------------------------------------------------	
// end of jquery area
// $(".perspective").on('click', function(){
// 	console.log( $(".card").attr('class') );
// 	if( $(".card").hasClass('flipped') )
// 	{
// 		$(".card").addClass('unflipped').removeClass('flipped');			
// 		$(".perspective").removeClass('active');
// 	}
// 	else
// 	{
// 		$(".card").addClass('flipped').removeClass('unflipped');
// 		$(".perspective").addClass('active');
// 	}
// });

});