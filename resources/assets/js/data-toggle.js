(function(window) {
  'use strict';

  window.dataToggle = function() {
    Array.prototype.slice.call(document.querySelectorAll('[data-toggle-target]')).forEach(function(trigger) {
      trigger.addEventListener('click', function() {
        // toggle class
        trigger.classList.toggle('is-toggled');

        document.querySelector('[data-toggle="'+trigger.getAttribute('data-toggle-target')+'"]').classList.toggle('is-toggled');
      });
    });
  };

})(window);
