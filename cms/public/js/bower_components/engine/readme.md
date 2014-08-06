# Engine
Engine is a paste in place selector engine / wrapper facilitating modern js DOM selectors (with polyfill).

The code is deliberately kept small and only optimises selections lightly around using `getElementByID`, `getElementsByClass` and `querySelectorAll`. The strength of engine is to make it dead simple to extend it.

## Browser support
IE9+

### Not shimmed functions
**trim** (engine.js, addClass, hasClass, removeClass, replaceClass)  
*Shim:* [ES5 Shim](https://github.com/es-shims/es5-shim)

**isArray** (css, class)  
*Shim:* [ES5 Shim](https://github.com/es-shims/es5-shim)

## Use engine to select

You can use `engine(selector)` or the shortcut `_(selector)` to get a selection of DOM-Elements. 

```javascript
engine('.class')
_('#id')
_('div > li') (anything that querySelectorAll eats)

var node = document.querySelectorAll('.class')[0];
_(node)
```

As a return value you get an array of the DOM-Selection 

```javascript
[<div class="class">DOM Element</div>]
```

You can use engine with the few build in methods (if you did not delete them, which you can do if you do not use them) or you own extensions like this.

```javascript
_('div').each(function(){ 
  // do something 
}).yourMethod(variable);
```

As long as you keep the chaining ability going you should be fine.

## Extending engine

Engine is build to easily add functionality like `parent()` or `each()` to a selection of DOM elements.

To extend engine simply add your function to `engine.fn` like so:
```javascript
engine.fn.each = function( fn ){
	if( typeof(fn) === 'function' ){
	  this.forEach(function(el, i){
	    fn(el, i);
	  });
	}
	return engine.fn.chain(); // keep chain up
};
```
 
