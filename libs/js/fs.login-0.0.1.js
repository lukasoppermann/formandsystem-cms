$(function(){
	// once jquery is loaded
	// --------------------------------------------------------------------
	var _window						= $(window);
	var _wrapper 					= $('#login');
	var _widget 					= $('.widget');
	var _active_users 				= $('.active-user');
	var _new_user					= $('.login');
	// inputs
	var _input_user 				= _new_user.find('.username');
	var _input_password 			= $('.password');
	var _input_password_clear		= $('.password-clear');
	var _input_full_name			= $('.full_name');
	// buttons
	var _btn_show_password 			= $('.show-password');
	var _btn_show_user				= $('#show_forgot_user');
	// buttons
	var _forgot_user_bubble			= $('#forgot_user_bubble');
	// links
	var _user_blocked				= $('.user-blocked');
	// given information
	var given_user					= null;
	var	timer_user					= null;
	var	user_image_class			= 'cms-profile';
	var pw_errors 					= 0;
	var old_password				= null;
	var old_username				= null;
	// --------------------------------------------------------------------
	// move login box to center	
	_wrapper.css({'marginLeft':-_wrapper.outerWidth()/2, 'marginTop':-250});
	// adjust position on resize
	_window.resize(function(){
		_wrapper.css({'marginLeft':-(_wrapper.outerWidth()/2+20), 'marginTop':-(_wrapper.height()/2)-50});	
	});
	// --------------------------------------------------------------------
	// if load-user class is set, get users from localStorage
	if( _wrapper.hasClass('load-user') )
	{
		// get users on load
		var users = $.get_local('user',true);
		// check if one or more users are stored 
		if( users !== false )
		{
			// load template
			$.ajax({
				url: CI_BASE+"ajax/template", 
				data: {template: 'login/user_active'}, 
				dataType: 'html',
				type: 'POST',
				success: function( data )
				{
					var active_user = $('<div>');
					var active_time = 0;
					var active = null;
					var stored_users = {};
					var timestamp = new Array();
					$.each(users, function( key, values )
					{
						if( values.time > active_time )
						{ 
							active_time = values.time; 
							active = key;
						}
						var temp = $(data).css({'top':-(_window.height()/2+200)});
						temp.find('.profile-image').attr('src',values.image);
						temp.find('.username').val(values.user);
						temp.find('.fullname').text(values.fullname);
						temp.find('.widget').addClass(key);
						stored_users[values.time] = temp;
						timestamp.push(values.time);
					});
					// sort users by timestamp
					timestamp.sort();
					timestamp.reverse();
					$.each(timestamp, function(i, val){
						active_user.prepend(stored_users[val]);
					});
					//
					_wrapper.prepend( active_user.html());
					var _inputs = $("[placeholder]", $('.active-user'));
					// add placeholders
					_inputs.each(function()
					{
						var _this = $(this);
						var _placeholder = $('<div class="placeholder">'+_this.attr('placeholder')+'</div>');
						// check if input is full
						if( _this.val().length != 0 )
						{
							// if so, hide placeholder
							_placeholder.hide();
						}
						// add placeholder
						_this.after(_placeholder).css({'background':'transparent'}).attr('placeholder','').attr('autocomplete','off');
					});
				
					var count = $('.active-user').size();
					$('.perspective').fadeIn();
					$($('.active-user').get().reverse()).each(function( i )
					{
						$(this).delay(150*i).animate({top: 0}, 900, 'easeInOutQuart');
						if (!--count)
						{
							setTimeout(function()
							{
								expand_user(_wrapper.find('.widget.'+active));
								_wrapper.animate({'marginLeft':-_wrapper.outerWidth()/2, 'marginTop':-250});
							}, 600+(150*i));
						}
					});
				}
			});
			//
		}
		// no user loaded from localStorage
		else
		{
			$('.perspective').addClass('flip single active').fadeIn();
			// select input field text
			setTimeout(function()
			{
				$('.perspective').find('input[type!=hidden]:visible:first').select();
			}, 100);
		}
	}
	// --------------------------------------------------------------------
	// submit form ajax
	_wrapper.on('submit', function(e)
	{
		// define variables
		var _active = _wrapper.find('.active');
		var password = _active.find('.password').val();
		var username = _active.find('.username').val();
		//
		if(old_password != password || old_username != username)
		{
			//
			old_password = password;
			old_username = username;
			// submit form via ajax
			$.ajax({
				url: CI_BASE+'ajax/user/login/',
				data: {'username':old_username, 'password':old_password},
				dataType: 'json',
				type: 'POST',
				success: function(response)
				{
					if( response.success === 'TRUE')
					{
						console.log(response);
						var timestamp = Math.round((new Date()).getTime() / 1000);
						$.update_local('user', old_username, {user:response.user, fullname:response.username, image: response.user_image, time: timestamp});
						window.location.reload();
					}
					else
					{
						// set error message
						_active.find('.login-errors').text(response.message).show().animate({'margin-top':-15}, 500);
						// check for type to show bubble
						if( response.error == 'password' )
						{
							// add error class to input
							_active.find('.password').addClass('error');
							// remove error from username
							_active.find('.username').removeClass('error');
							// check for bubble
							if( ++pw_errors > 2 )
							{
								bubble(_active.find('.forgot-password-bubble'));
							}
						}
						else
						{
							bubble(_active.find('.forgot-password-bubble'), true);
						}
					
						if( response.error == 'username' )
						{
							if( _active.find('.username').is(':hidden') )
							{
								// add error class to input
								_active.find('.password').addClass('error');
							}	
							else
							{
								// add error class to input
								_active.find('.username').addClass('error');
								// remove error from password
								_active.find('.password').removeClass('error');
							}
							if( response.user_blocked == 'TRUE' )
							{
								bubble(_active.find('.blocked-user-bubble'));
							}
							else
							{
								bubble(_active.find('.blocked-user-bubble'), true);
							}
							//
							if( response.user_blocked != 'TRUE' )
							{
								bubble(_active.find('#forgot_user_bubble'));
							}
							else
							{
								bubble(_active.find('#forgot_user_bubble'), true);
							}
						}
						else
						{
							bubble(_active.find('.blocked-user-bubble'), true);
							bubble(_active.find('#forgot_user_bubble'), true);
						}
					}
				}
			});
		}
		// return false
		return false;
	});
	// --------------------------------------------------------------------
	// show user retrieve window on click
	_btn_show_user.on('click', function()
	{
		bubble(_forgot_user_bubble);
	});
	// --------------------------------------
	// fn for bubble link events
	var retrieval_pending = null;
	_wrapper.on('click', '.retrieval-link', function()
	{
		var _this = $(this);
		var user = _this.parents('.widget').find('.'+_this.data('post')).val();
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
	if(_new_user.find('.username').val() != '')
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
		if($(this).val() == '')
		{
			// fadein button
			_btn_show_user.show().animate({'opacity':0.4}, 300);
		}
	});
	// ---------------------------
	// fn bubble
	function bubble( bubble, hide )
	{
		if( hide !== true )
		{
			if( bubble.hasClass('hidden') )
			{
				bubble.css({'right':'+=35','opacity':'0'}).show().removeClass('hidden').animate({'right':'-=35','opacity':'1.0'});
			}
			else
			{
				bubble.animate({'opacity':'0'}, function(){
					bubble.addClass('hidden').show();
				});
			}
		}
		else
		{
			bubble.animate({'opacity':'0'}, function(){
				bubble.addClass('hidden');
			});
		}
	}
	// --------------------------------------------------------------------
	// show/hide show password icon
	// --------------------
	// typing into password field
	_wrapper.on({
		keyup: function()
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
		},
		blur: function()
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
		}
	},'.password');
	// --------------------
	// password clear field
	_wrapper.on({
		// on blur password clear field
		blur: function()
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
		},
		// if typing in clear password field
		keyup: function()
		{
			// assing variables
			var _input_password_clear 			= $(this);
			// update real password field
			_input_password_clear.siblings('.password').val( _input_password_clear.val() );
		}
	}, '.password-clear');
	// --------------------------------------------------------------------
	// show / hide password clear text
	_wrapper.on('click', '.show-password', function()
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
			_input_password_clear.val('').removeClass('hidden').focus().val( _input_password.val() );
		}
		// if clear password is active
		else
		{
			// set button to "visible" [icon] 
			_btn_show_password.removeClass('active invisible').addClass('visible');
			// update real password field
			_input_password.val( _input_password_clear.val() ).focus();
			// hide clear password field
			_input_password_clear.addClass('hidden');
		}
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
			get_user_data( _input_user.parents('.widget') );
		}, 1300);
	});
	// ---------------------------
	// fn get user data
	function get_user_data( widget )
	{
		// check if user-name/email has changed since last request
		if( given_user != _input_user.val() )
		{
			var _user_image_wrapper		= widget.find('.user-image');
			var _user_name 				= _user_image_wrapper.find('.fullname');
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
					_user_name.fadeOut();
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
	// add click event to widgets
	_wrapper.on('mousedown', '.user-image, .login .user-image', function()
	{
		// get widget and set active
		var _this_widget = $(this).parents('.widget');
		// check if widget is not active
		if( !_this_widget.hasClass('active') )
		{
			// contract active widget
			contract_user( $('.active-user').find('.widget.active') );
			// add active class to widget
			_this_widget.addClass('active');
			// if clicked is not new user
			if( !_this_widget.hasClass('login') )
			{
				// expand user widget
				expand_user(_this_widget);
				// contract active user
				bubble(_new_user.find('.bubble'), true);
				_new_user.find('.login-errors').animate({'margin-top':-150}, function(){
					_new_user.find('.login-errors').hide();
				});
				setTimeout(function()
				{
					_new_user.removeClass('active').parents('.perspective').removeClass('flip');
				}, 100);
			}
		}
		// select input field text
		setTimeout(function()
		{
			_this_widget.find('input[type!=hidden]:visible:first').select();
		}, 100);
	});
	// ---------------------------
	// fn contract user
	function contract_user( widget )
	{
		// define variables
		var password = widget.find('.form-element');
		var timeout = 0;
		//
		if( widget.find('.bubble:not(.hidden)').size() != 0 ){ timeout = 150; }
		// remove bubble
		bubble(widget.find('.bubble'), true);
		setTimeout(function()
		{
			// contract widget
			widget.animate({'width': '210', 'height': '210', 'marginTop': '-100', 'marginLeft': '-100'}, 250, 'easeInOutQuart', function()
			{
				// remove class 'active'
				widget.removeClass('active');
			});
			// contract widget-content and remove padding
			widget.find('.widget-content').animate({'height': '190', 'width':'190', 'padding': '0'}, 250, 'easeInOutQuart');
			widget.find('.user-image').animate({'height':'180', 'width':'180'}, 250, 'easeInOutQuart');
			// slide away password input
			password.animate({'marginTop': '-35', 'opacity': 0}, 250, 'easeInOutQuart', function()
			{
				// display none password input
				password.css({'display':'none'});
			});
			// slide errors away
			widget.find('.login-errors').animate({'margin-top':-150, 'display':'none'});
		}, timeout);
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
		widget.find('.form-element').show().delay(50).animate({'marginTop': 5, 'opacity': 1}, 160, 'easeInOutQuart', function(){
			$(this).find('.password').select();
			$(this).find('.password-clear').select();
		});
		// slide errors in
		var _errors = widget.find('.login-errors');
		if( $.trim(_errors.text()).length != 0)
		{
			_errors.animate({'margin-top':-15, 'display':'block'}, 500);
		}
	}
	// --------------------------------------------------------------------
	// hover new user
	_wrapper.on({
		mouseover: function()
		{
			$(this).addClass('flip');
		},
		mouseleave: function()
		{
			var _this = $(this);
			if( _this.find('input:focus').size() <= 0 && !_this.hasClass('single') && (!_new_user.hasClass('active') ||
				_this.find(":input[value='']").size() == _this.find('input').size()))
			{
				bubble(_this.find('.bubble'), true);
				_this.find('.login-errors').animate({'margin-top':-150}, function(){
					_this.find('.login-errors').hide();
				});
				setTimeout(function()
				{
					_this.removeClass('flip');
				}, 400);
			}
		}
	}, '.perspective');
	
	$('.perspective').on('click', 'input', function()
	{
		_new_user.addClass('active');
		contract_user($('.active-user').find('.active'));
	});
// --------------------------------------------------------------------	
// end of jquery area
});