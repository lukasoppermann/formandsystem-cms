/* toggle section settings */
APP.eventEmitter.on('toggle-settings', function(data) {
  data.this.parentNode.querySelector('[data-js*="settings-content"]').classList.toggle('is-toggled');
});
/* toggle confirm button */
APP.eventEmitter.on('button-confirm', function(data) {
  data.this.classList.toggle('is-toggled');
  data.this.parentNode.querySelector('[data-js="confirm-second-state"]').classList.toggle('is-toggled');
});
/* cancel confirm button */
APP.eventEmitter.on('button-confirm-cancel', function(data) {
  data.this.parentNode.classList.toggle('is-toggled');
  data.this.parentNode.parentNode.querySelector('[data-js="confirm-first-state"]').classList.toggle('is-toggled');
});
/* cancel confirm button on closing settings */
APP.eventEmitter.on('toggle-settings', function(data) {
  if (data.this.parentNode.querySelector('[data-js*="settings-content"]').classList.contains('is-toggled')) {
    data.this.parentNode.querySelector('[data-js="confirm-first-state"]').classList.add('is-toggled');
    data.this.parentNode.querySelector('[data-js="confirm-second-state"]').classList.remove('is-toggled');
  }
});
/* cancel settings on opening settings */
APP.eventEmitter.on('toggle-settings', function(data) {
  if (!data.this.parentNode.querySelector('[data-js*="settings-content"]').classList.contains('is-toggled')) {
    Array.prototype.slice.call(document.querySelectorAll('[data-js*="settings-content"]')).forEach(function(item) {
      if (item.classList.contains('is-toggled')) {
        APP.eventEmitter.emit('toggle-settings', {'this':item, 'data':null});
      }
    });
  }
});
/* confirm delete button */
APP.eventEmitter.on('button-confirm-confirm', function(data) {
  if (data.action === 'delete-section') {
    var section = document.querySelector('[data-pos="'+data.pos+'"]');
    section.parentNode.removeChild(section);
    APP.eventEmitter.emit('save-page');
  }
});

/* save current page */
APP.eventEmitter.on('save-page', function(data) {
  savePage();
});
