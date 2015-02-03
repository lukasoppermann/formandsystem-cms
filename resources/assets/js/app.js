$(document).ready(function(){

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
  //
  nestable('.content-body', {
    itemClass: 'js-editor-section',
    handleClass: 'js-editor-section-dragHandler',
    forcePlaceholderSize: true,
    placeholderClass: 'section-placeholder'
  });

  nestable('.editor-inner-section', {
    itemClass: 'column',
    handleClass: 'js-fragment',
    forcePlaceholderSize: true,
    placeholderClass: 'fragment-placeholder'
  });
  $('.editor-inner-section').on('sortstart', function(){
    $('body').addClass('sorting-fragment');
  });
  $('.editor-inner-section').on('sortupdate', function(){
    console.log('off');
  });
    //
    // nestable('.editor-inner-section', 'disable');
  var editors = [];
  $('.mark').each(function(){
    var editor = CodeMirror.fromTextArea($(this).find('.textarea')[0], {
        mode: 'gfm',
        theme: 'mark',
        content: $(this).find('.textarea').text()
    });
    editors.push(editor);
    this.setAttribute('data-mark', editors.length-1);
  //
  //     _that.editor.on("mousedown", function(cm){
  //       _that.t = setTimeout(function() {
  //         $('.editor-inner-section').find('.dragger').show();
  //         nestable('.editor-inner-section', 'enable');
  //         console.log(_that.editor);
  //         _that.editor.getInputField().blur();
  //       }, 500);
  //     });
  //
  //     _that.editor.on("mouseup", function(cm){
  //       console.log('yo:');
  //       console.log(_that.t);
  //       clearTimeout(_that.t);
  //     });
  //
  //     _that.editor.on("mousemove", function(cm){
  //       clearTimeout(_that.t);
  //     });
  //
      editor.on("focus", function(cm){
        $(cm).parents('.js-fragment').addClass('is-focused');
      });

      editor.on("blur", function(cm){
        $(cm.display.wrapper).parents('.js-fragment').removeClass('is-focused');
      });

  });

});
