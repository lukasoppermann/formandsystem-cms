(function(define, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		
		
		// Module: addClass
		engine.fn.addClass = function(classes){
			if( classes !== undefined && classes.trim().length > 0 ){
				classes = classes.split(' ');
				this.forEach(function(el, i){
					for (var c = classes.length; c--;){
						if (el.classList){
							el.classList.add(classes[c]);
						}else{
							el.className += ' ' + classes[c];
						}
					}
				});
			}
			return this;
		};
		
		
		// Module: removeClass
		engine.fn.removeClass = function(classes){
			if( classes !== undefined && classes.trim().length > 0 && Array.isArray(this)){
				classes = classes.split(' ');
				this.forEach(function(el, i){
					for (var c = classes.length; c--;){
						if (el.classList){
							el.classList.remove(classes[c]);
						}else{
							el.className = el.classes.replace(new RegExp('(^| )' + classes[c].join('|') + '( |$)', 'gi'), ' ');
						}
					}
				});
			}
			return this;
		};
		
		
		// Module: hasClass
		engine.fn.hasClass = function(classname){
			var has = true;
			
			if (!this[0].classList){
				this.forEach(function(el, i){
					if( !el.classList.contains(classname) )
					{
						has = false;
						return;
					}
				});
			}else{
				this.forEach(function(el, i){
					if( (' ' + el.className + ' ').indexOf(' ' + classname + ' ') === -1 )
					{
						has = false;
						return;
					}
				});
				
			}
			
			// return true or false
			return has;
		};
		
		// Module: replaceClass
		engine.fn.replaceClass = function(regex, replace){
			if( regex !== undefined && regex.trim().length > 0 ){
				var regx = new RegExp('(' + regex + ')', 'g');
				this.forEach(function(el, i){
					el.className = el.className.replace(regx, replace).trim();
				});
			}
			return this;
		};
		
		
		// return engine obj
		return engine;
	});
//	
}(window.define));