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
    item: '.js-editor-section',
    handle: '.js-editor-section-dragHandler',
    forcePlaceholderSize: true,
    placeholderClass: 'section-placeholder'
  });

  nestable('.editor-inner-section', {
    item: '.column',
    handle: '.js-fragment',
    forcePlaceholderSize: true,
    placeholderClass: 'fragment-placeholder'
  });

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

  keymage.setScope('editor');
  var fragmentFns = {
    text: function(){
      var editor = editors[this.querySelector('.mark').getAttribute('data-mark')];
      return editor.getValue("");
    }
  };

  keymage('editor','cmd-s', function() {

    var i = 0,
    columns = nestable('.editor-inner-section').serialize(function(){
      var fragment = this.querySelector('.js-fragment');
      return {
        offset: parseInt(this.getAttribute('data-offset')),
        column: parseInt(this.getAttribute('data-column')),
        fragmentId: parseInt(fragment.getAttribute('data-fragment-id')),
        fragmentKey: fragment.getAttribute('data-fragment-key'),
        fragmentType: fragment.getAttribute('data-fragment-type'),
        fragmentContent: fragmentFns[fragment.getAttribute('data-fragment-type')].call(fragment)
      };
    });
    var serialized = nestable('.content-body').serialize(function(){
      return {
        children: columns[i++],
        class: this.getAttribute('data-class'),
        link: this.getAttribute('data-link')
      };
    });
    
    $.ajax({
      url: "/pages/"+document.querySelector('[data-page]').getAttribute('data-page-id'),
      type: "PUT",
      data: JSON.stringify(serialized),
      dataType: "json"
    });
  }, {preventDefault: true});
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
