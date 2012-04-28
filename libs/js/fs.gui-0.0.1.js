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
// end of jquery area
});