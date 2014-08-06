(function(window, define, undefined){
	// POLYFILLS
	if (window.Element){
		(function(ElementPrototype) {
			ElementPrototype.matches = ElementPrototype.matchesSelector =
	    ElementPrototype.matchesSelector ||
			ElementPrototype.webkitMatchesSelector ||
			ElementPrototype.mozMatchesSelector ||
			ElementPrototype.msMatchesSelector ||
			ElementPrototype.oMatchesSelector ||
			function (selector) {
	      var nodes = (this.parentNode || this.document).querySelectorAll(selector), i = -1;
				while (nodes[++i] && nodes[i] !== this);
				return !!nodes[i];
			};
		})(window.Element.prototype);
	}
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// Module: get parent of element	
		engine.fn.parent = function(selector){
			engine.selection = [];
		  this.forEach(function(el, i){
				el = el.parentNode;
				if( selector !== undefined ){
				  while(el.parentNode !== null && !el.matches(selector) && el.nodeName !== 'BODY'){
				    el = el.parentNode;
				  }
					el.matches(selector) && engine.selection.indexOf(el) === -1 ? engine.selection.push(el) : '';
				}else if(el !== null){
					if(engine.selection.indexOf(el) === -1){
						engine.selection.push(el);
					}
				}
			});
			// return a chainable engine object
			return engine.chain();
		};
		return engine;
	});
//	
}(window, window.define));