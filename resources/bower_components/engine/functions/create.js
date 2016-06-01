(function(define, document, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// Module: create
		engine.create = function(htmlString, string){
			
			var doc = document.createElement('div');
			
			if( typeof(htmlString) === "string" )
			{
				// create closing tag
				var closingTag = htmlString;
				var index = htmlString.indexOf(' ');
				if( index >= 0)
				{
					closingTag = htmlString.substr(0,index);
				}
				// close
				closingTag.replace('<','</');
				// create element
				doc.innerHTML = htmlString+closingTag;
			}
			else
			{
				if( typeof(htmlString[0]) === "object" )
				{
					doc.appendChild(htmlString[0]);
				}
				else
				{
					doc.appendChild(htmlString);
				}
			}
			// return string
			if( string === true )
			{
				return doc.innerHTML;
			}
			// return node
			return doc.children[0];
		};
		
		// Module: after
		engine.fn.after = function( element ){
			
			if( typeof(element) === "string" ){
				element = engine.create(element);
			}
			else if( Array.isArray(element) )
			{
				element = element[0];
			}
			
			this.forEach(function(el, i){
				
				if( el.nextElementSibling !== undefined )
				{
					el.parentNode.insertBefore(element, el.nextElementSibling);
				}
				else
				{
					el.parentNode.appendChild(element);
				}
			});
			return this;
		}

		// Module: before
		engine.fn.before = function( element ){
			if( typeof(element) === "string" ){
				element = engine.create(element);
			}
			else if( Array.isArray(element) )
			{
				element = element[0];
			}
			
			this.forEach(function(el, i){
				el.parentNode.insertBefore(element, el);
			});
			return this;
		}

		// Module: before
		engine.fn.append = function( element ){
			
			if( typeof(element) === "string" ){
				element = engine.create(element);
			}
			else if( Array.isArray(element) )
			{
				element = element[0];
			}
			
			this.forEach(function(el, i){
				el.appendChild(element);
			});
			return this;
		}
		
		// Module: remove
		engine.fn.remove = function( ){
			
			this.forEach(function(el, i){
				el.parentNode.removeChild(el);
			});
			
		}
		
		return engine;
	});
//	
}(window.define, document));