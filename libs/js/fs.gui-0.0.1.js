$(function(){
	// once jquery is loaded
	// --------------------------------------------------------------------
	var _sub_menu_bar = $("#sub_menu_bar");
	if(	$.trim(_sub_menu_bar.text()) != '')
	{
		_sub_menu_bar.animate({'marginTop':'+='+45}, 500, 'swing');
	}
	// --------------------------------------------------------------------
	// add focus to first failed field
	$('.form-element').find('.error').first().focus().select();
	// --------------------------------------------------------------------
	// bubble
	$('.bubble.right').each(function(){
		$(this).css({'right':'+=30','opacity':'0'}).animate({'right':'-=30','opacity':'1.0'});
	});
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
	// placeholders
	var _inputs = $("[placeholder]");
	// add placeholders
	_inputs.each(function()
	{
		var _this = $(this);
		_this.after($('<div class="placeholder">'+_this.attr('placeholder')+'</div>')).css({'background':'transparent'}).attr('placeholder','');
	});
	// add placeholder events
	_inputs.on({
		keydown: function()
		{
			$(this).next('.placeholder').hide();
		},
		keyup: function()
		{
			var _this = $(this);
			if( _this.val() == '' )
			{
				_this.next('.placeholder').fadeIn(200);
			}
		},
		blur: function()
		{
			var _this = $(this);
			if( _this.val() == '' )
			{
				_this.next('.placeholder').fadeIn(200);
			}
		}
	});
// end of jquery area
});