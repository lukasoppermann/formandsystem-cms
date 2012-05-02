$(function(){
	// once jquery is loaded
	// --------------------------------------------------------------------
	var _wrapper 					= $('#login');
	// inputs
	var _input_user 				= $('#username');
	var _input_password 			= $('#password');
	var _input_password_clear		= $('#password_clear');
	var _input_full_name			= $('#full_name');
	// buttons
	var _btn_show_password 			= $('#show_password');
	var _btn_show_user				= $('#show_forgot_user');
	// buttons
	var _forgot_user_bubble			= $('#forgot_user_bubble');
	var _forgot_password_bubble 	= $('#forgot_password_bubble');
	// links
	var _retrieve_password 			= $('#retrieve_password');
	var _user_blocked				= $('#user_blocked');
	// user data
	var _user_name					= $('.username');
	var _user_image					= $('.profile-image');
	var _user_image_wrapper			= $('.user-image');
	// given information
	var given_user					= null;
	var	timer_user					= null;
	var	user_image_class			= 'cms-profile';
	// --------------------------------------------------------------------
	// move login box to center	
	_wrapper.css({'marginLeft':-_wrapper.width()/2, 'marginTop':-(_wrapper.height()/2)-50});
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
			_forgot_user_bubble.css({'right':'+=30','opacity':'0'}).removeClass('hidden').animate({'right':'-=30','opacity':'1.0'});
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
	if(_input_user.val() != '')
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
	// show password visibility icon
	if(_input_password.val() != '')
	{
		// fadein if password field is not empty
		_btn_show_password.show().animate({'opacity':0.4}, 300);
	}
	// typing into password field
	_input_password.on('keyup', function()
	{
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
	// on blur password field
	_input_password.on('blur', function()
	{
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
		// update real password field
		_input_password.val( _input_password_clear.val() );
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
		get_user_data();
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
			get_user_data();
		}, 1300);
	});
	// ---------------------------
	// fn get user data
	function get_user_data()
	{
		// check if user-name/email has changed since last request
		if( given_user != _input_user.val() )
		{
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
	// select active user
	var _active_user = $(".active-user");
	// add click event to active user cards
	_active_user.on('click', function()
	{	
		// get clicked widget	
		var _widget = $(this).children('.widget');
		// check if widget is not active
		if( !_widget.hasClass('active') )
		{
			// expand user widget
			expand_user(_widget);
			// contract active user
			contract_user(_active_user.find('.active'));
		}
	});
	// ---------------------------
	// fn contract user
	function contract_user( widget )
	{
		// define variables
		var password = widget.find('.form-element');
		// contract widget
		widget.animate({'width': '200', 'height': '200', 'marginTop': '-100'}, 250, 'easeInOutQuart', function()
		{
			// remove class 'active'
			widget.removeClass('active');
		});
		// contract widget-content and remove padding
		widget.find('.widget-content').animate({'height': '180', 'padding': '0'}, 250, 'easeInOutQuart');
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
		widget.animate({'width': '290', 'height': '350', 'marginTop': '-160'}, 250, 'easeInOutQuart', function()
		{
			// add class 'active'
			widget.addClass('active');
		});
		// expand widget content
		widget.find('.widget-content').animate({'height':'300', 'padding': '5'}, 250, 'easeInOutQuart');
		// slide in password input
		widget.find('.form-element').css({'display':'block'}).delay(50).animate({'marginTop': 5}, 160, 'easeInOutQuart');
	}
// --------------------------------------------------------------------	
// end of jquery area
$(".perspective").on('click', function(){
	console.log( $(".card").attr('class') );
	if( $(".card").hasClass('flipped') )
	{
		$(".card").addClass('unflipped').removeClass('flipped');			
		$(".perspective").removeClass('active');
	}
	else
	{
		$(".card").addClass('flipped').removeClass('unflipped');
		$(".perspective").addClass('active');
	}
});

});