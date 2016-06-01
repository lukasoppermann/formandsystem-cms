(function(window, define, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// Module: css getter and setter
		engine.fn.css = function(attr, val){
			if( attr !== undefined )
			{
				if( (val === undefined || val === 'float') && typeof(attr) !== 'object' )
				{
					var float = (val === 'float' ? true : false);
					if ('getComputedStyle' in window)
					{
						val = window.getComputedStyle(this[0], null).getPropertyValue(attr).replace(/^px+|px+$/g, '');
					}
					else if ('currentStyle' in window.element)
					{
						val = this[0].currentStyle[attr].replace(/^px+|px+$/g, '');
					}
					// if not a number
					if( !isNaN(val) ){
						if( float === true ){
							return parseFloat(val);
						}
						return parseInt(val);
					}
					
					return val;
				}
				else
				{
					if( typeof(attr) === 'object' )
					{
						for(var key in attr) {
							this.forEach(function(el, i){
								el.style[key] = attr[key];
							});
						}
					}
					else
					{
						this.forEach(function(el, i){
							el.style[attr] = val;
						});
					}
				}
			}
	    // return properties
			return this;
		};
		return engine;
	});
//	
}(window, window.define));