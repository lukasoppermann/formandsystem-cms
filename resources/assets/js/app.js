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
  $('.content-body').sortable({
    item: '.js-editor-section',
    forcePlaceholderSize: true,
    handle: '.js-editor-section-dragHandler'
  });


    $('.editor-inner-section').sortable({
      item: '.column',
      forcePlaceholderSize: true,
      connectWith: '.editor-inner-section'
    });

    $('.editor-inner-section').sortable('disable');

  $('.mark').each(function(){
    var _that = this;

    _that.editor = CodeMirror.fromTextArea($(this).find('.textarea')[0], {
        mode: 'gfm',
        theme: 'mark',
        content: $(this).find('.textarea').text()
      });

      _that.editor.on("mousedown", function(cm){
        _that.t = setTimeout(function() {
          $('.editor-inner-section').find('.dragger').show();
          $('.editor-inner-section').sortable('enable');
          console.log(_that.editor);
          _that.editor.getInputField().blur();
        }, 500);
      });

      _that.editor.on("mouseup", function(cm){
        console.log('yo:');
        console.log(_that.t);
        clearTimeout(_that.t);
      });

      _that.editor.on("mousemove", function(cm){
        clearTimeout(_that.t);
      });

      // yo.on("focus", function(cm){
      //   console.log(cm);
      //   $(cm).parents('.js-fragment').addClass('is-focused');
      // });
      //
      // yo.on("blur", function(cm){
      //   $(cm).parents('.js-fragment').removeClass('is-focused');
      // });

  });

  // $('.mark').attr('draggable', true);

  // $('.dragger').on('click', function(){
  //   $(this).hide();
  //
  // }).on('doubleclick', function(){
  //   alert('now');
  // });

  $('.dragger').click(function(e) {
    var _that = $(this);
    setTimeout(function() {
        var dblclick = parseInt(_that.data('double'), 10);
        if (dblclick > 0) {
            _that.data('double', dblclick-1);
        } else {
            // singleClick.call(that, e);
            _that.hide();
        }
    }, 300);
  }).dblclick(function(e) {
      $(this).data('double', 2);
      // doubleClick.call(this, e);
      alert('now');
  });

$('.column').on('mousedown', function(e) {
  this.t = setTimeout(function() {
    $('.editor-inner-section').find('.dragger').show();
    $('.editor-inner-section').sortable('enable');

  }, 500);
}).on('mouseup', function(e){
  clearTimeout(this.t);
}).on('mousemove', function(e){
  clearTimeout(this.t);
});

});
