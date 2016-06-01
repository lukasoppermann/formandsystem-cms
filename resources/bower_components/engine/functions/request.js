(function(define, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// Module: isJson
		engine.isJson = function(jsonString){
			try {
				var object = JSON.parse(jsonString);
				if (object && typeof object === "object" && object !== null) {
					return object;
				}
			}
			catch (e) { }
			return false;
		}
		// functions to add events
		engine.request.events = {
			success: function(){},
			error: function(){},
			fail: function(){}
		};
		
		// Module: ajax
		engine.request = function(url, data, method){
			method = (method !== undefined) ? method : ( ( data !== undefined ) ? 'POST' : 'GET' );
			var request = new XMLHttpRequest();
			request.open(method, url, true);
			// set data & request header
			if( method === 'POST' || method === 'PUT' ){
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				// check if data is a string already
				if( typeof data !== "string" )
				{
					data = JSON.stringify(data);
				}
			}
			// handle request feedback
			request.onload = function(){
				if (request.status >= 200 && request.status < 400){
					engine.request.events['success'](request, (o = engine.isJson(data)) ? o : data );
				} else {
					engine.request.events['fail'](request);
				}
			};
			// on error (connection error)
			request.onerror = function() {
				engine.request.events['error'](request);
			};
			// send request
			request.send(data);
			// return request for chainability
			return engine.request;
		};

		engine.request.success = function(fn){
			if( typeof(fn) !== undefined){
				engine.request.events['success'] = fn;
			}
			return engine.request;
		};
		engine.request.error = function(fn){
			if( typeof(fn) !== undefined){
				engine.request.events['error'] = fn;
			}
			return engine.request;
		};
		engine.request.fail = function(fn){
			if( typeof(fn) !== undefined){
				engine.request.events['failed'] = fn;
			}
			return engine.request;
		};
		
		return engine;
	});
//	
}(window.define));