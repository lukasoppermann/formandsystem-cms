/* -- JSHint --*/
/*global $, nestable, keymage, CodeMirror*/
var editors = [];

nestable('.content-body', {
  item: '.js-editor-section',
  handle: '.js-editor-section-dragHandler',
  list: '.content-body',
  forcePlaceholderSize: true,
  placeholderClass: 'section-placeholder'
});

nestable('.editor-inner-section', {
  item: '.column',
  handle: '.js-fragment',
  list: '.editor-inner-section',
  connected: 'grids',
  forcePlaceholderSize: true,
  placeholderClass: 'fragment-placeholder'
});

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

  $('.content-body').on('sortupdate', function(){
    console.log('yo');
    console.log(nestable('.content-body').serialize());
  });

  $('.editor-inner-section').on('sortstart', function(){
    $('body').addClass('sorting-fragment');
  });
  $('.editor-inner-section').on('sortupdate', function(){
    console.log('off');
  });


    // nestable('.editor-inner-section', 'disable');

  $('.mark').each(function(){
    var editor = CodeMirror.fromTextArea($(this).find('.textarea')[0], {
        mode: 'gfm',
        theme: 'mark',
        content: $(this).find('.textarea').text()
    });
    editors.push(editor);
    this.setAttribute('data-mark', editors.length-1);

      editor.on('focus', function(cm){
        $(cm).parents('.js-fragment').addClass('is-focused');
      });

      editor.on('blur', function(cm){
        $(cm.display.wrapper).parents('.js-fragment').removeClass('is-focused');
      });

  });

  dataToggle();

  addEditorSection('[data-js*="addEditorSection"]', '[data-js="tempalteEditorSection"]');

});
