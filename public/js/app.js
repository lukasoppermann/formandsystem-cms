$(function(){

  $('body').on('mouseenter', '.js-editor-section-dragHandler', function(){
    $(this).parents('.js-editor-section').addClass('drag-is-active');
  }).on('mouseleave', '.js-editor-section-dragHandler', function(){
    $(this).parents('.js-editor-section').removeClass('drag-is-active');
  });

    $('body').on('mouseenter', '.js-fragment', function(){
      $(this).parents('.js-editor-section').addClass('child-is-active');
    }).on('mouseleave', '.js-fragment', function(){
      $(this).parents('.js-editor-section').removeClass('child-is-active');
    });

});
