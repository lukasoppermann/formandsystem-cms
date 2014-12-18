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

  $('.mark').each(function(){
      var yo = CodeMirror.fromTextArea($(this).find('.textarea')[0], {
        mode: 'gfm',
        theme: 'mark',
        content: $(this).find('.textarea').text()
      });

      yo.on("focus", function(cm){
        console.log(cm);
        $(cm).parents('.js-fragment').addClass('is-focused');
      });

      yo.on("blur", function(cm){
        $(cm).parents('.js-fragment').removeClass('is-focused');
      });

  });

  $('.mark').attr('draggable', true);

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

$('.mark').on('mousedown', function(e) {
  this.t = setTimeout(function() {
    alert('now2');
  }, 500);
}).on('mouseup', function(e){
  clearTimeout(this.t);
}).on('mousemove', function(e){
  clearTimeout(this.t);
});

});
