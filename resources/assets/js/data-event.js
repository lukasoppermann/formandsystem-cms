(function(window) {
  'use strict';

  var eventTypes = ['click'];

  var emitEvent = function(eventName, trigger, data) {
    data = data || {};
    data.this = trigger;
    APP.eventEmitter.emit(eventName, data);
  };

  var parseData = function(data) {
    if (data === null) {
      return;
    }
    try {
      return JSON.parse(data);
    } catch(e) {
      return {
        variable: data,
      };
    }
  };

  var triggerEvent = function(el, eventType) {
    if (el.getAttribute('data-'+eventType) !== null) {
      emitEvent(el.getAttribute('data-'+eventType), el, parseData(el.getAttribute('data-event-variable')));
    }
  };

  window.triggerDataEvent = triggerEvent;

  // initiate events
  window.initDataEvents = function() {
    eventTypes.forEach(function(eventType) {
      Array.prototype.slice.call(document.querySelectorAll('[data-'+eventType+']')).forEach(function(trigger) {
        trigger.addEventListener(eventType, function() {
          triggerEvent(trigger, eventType);
        });
      });
    });
  };

})(window);
