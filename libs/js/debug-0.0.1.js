$(function(){
    $('.log-close').on('click', function(){
        $(this).parents('.log-container').fadeOut('slow',function(){
           $(this).remove();
        });
	});
});