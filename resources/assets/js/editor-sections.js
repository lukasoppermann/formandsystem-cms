(function(window){
  'use strict';
  window.addEditorSection = function(selector, templateSelector){
    Array.prototype.slice.call(document.querySelectorAll(selector)).forEach( function(el){
      el.addEventListener('click', function(){
        el.insertAdjacentHTML('beforebegin', templateEditorSection);
        nestable('.content-body', {
          item: '.js-editor-section',
          handle: '.js-editor-section-dragHandler',
          list: '.content-body',
          forcePlaceholderSize: true,
          placeholderClass: 'section-placeholder'
        });
      });
    });
  };
})(window);
