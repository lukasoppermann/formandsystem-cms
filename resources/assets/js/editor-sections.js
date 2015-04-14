(function(window){
  'use strict';
  window.addEditorSection = function(selector, templateSelector){
    Array.prototype.slice.call(document.querySelectorAll(selector)).forEach( function(el){
      el.addEventListener('click', function(){
        var template = APP.templates.section;
        template = template.replace('{{$pos}}',document.querySelectorAll('.js-editor-section').length);
        template = template.replace(/{{[^}]*}}/g,'');
        el.insertAdjacentHTML('beforebegin', template);
        nestable('.content-body').destroy();
        nestable('.content-body', {
          item: '.js-editor-section',
          handle: '.js-editor-section-dragHandler',
          list: '.content-body',
          forcePlaceholderSize: true,
          placeholderClass: 'section-placeholder'
        });
        initDataEvents();
      });
    });
  };
})(window);
