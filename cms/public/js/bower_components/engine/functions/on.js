(function(define, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// Module: addEvent
		engine.fn.on = function(eventName, eventHandler, target, time){
			
			// check if an element is given
			if(this.length > 0 && this[0] != null){

				// set time
				time = (typeof target === "number" ? target : (time !== undefined ? time : 10));
				
				// loop through selection
				this.forEach(function(el, i){
					
					// prepare fn and storage
					var fn = function(e){
						// set target
						t = ( target !== undefined && typeof target !== "number" ? engine.fn.find(target, engine.fn.find(el))  : false );
						// only if target fits selection, execute event
						if( t === false || t.indexOf(e.target) !== -1){
							
							// if a delay is set (debounce)
							if( time > 0 )
							{
								clearTimeout( this.f );
								this.f = setTimeout(eventHandler.bind(e.target, e), time);
							
								// if no delay is set, call immediatly
							} else {
								eventHandler.call(e.target, e);
							}
							
						}
					}
					
					// if element has no events property, add it
					!('events' in el) ? el['events'] = [] : '' ;
					
					// add events to elemens and store in element to delete later
					eventName.split(" ").forEach(function(name){
						
						// add property with event name, if it does not exist
						!(name in el['events']) ? el['events'][name] = [] : '' ;
						
						// add event to listener and storage
						el['events'][name].push(fn);
						el.addEventListener(name, fn, false);
						
					});
				});
				
			}
				
			return this;
		};
		return engine;
	});
//	
}(window.define));