(function(window, define, undefined){
	// polyfill
	if(!window.CustomEvent){
		var CustomEvent = function(event, params) {
		  var evt;
		  params = params || {
		    bubbles: false,
		    cancelable: false,
		    detail: undefined
		  };
		  evt = document.createEvent("CustomEvent");
		  evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
		  return evt;
		};
		CustomEvent.prototype = window.Event.prototype;
		window.CustomEvent = CustomEvent;
	}
	if(!window.dispatchEvent){
		WindowPrototype[dispatchEvent] = DocumentPrototype[dispatchEvent] = ElementPrototype[dispatchEvent] = function (eventObject) {
			return this.fireEvent("on" + eventObject.type, eventObject);
		};
	}
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// removeEvent	
		engine.fn.trigger = function(eventName, eventData){
			this.forEach(function(el){
				var event = new window.CustomEvent(eventName, eventData);
				el.dispatchEvent(event);
			});
			return this;
		};
		return engine;
	});
//	
}(window, window.define));