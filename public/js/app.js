/*
 * Engine
 *
 * @description: Paste in place easily extendable selector engine
 *
 * Copyright 2014, Lukas Oppermann
 * Released under the MIT license.
 */
(function( window, document, define, undefined ) {
	// set to strict in closure to not break other stuff
  'use strict';
	// POLYFILLS
	if (!document.querySelectorAll) {
	  document.querySelectorAll = function (selectors) {
	    var style = document.createElement('style'), elements = [], element;
	    document.documentElement.firstChild.appendChild(style);
	    document._qsa = [];

	    style.styleSheet.cssText = selectors + '{x-qsa:expression(document._qsa && document._qsa.push(this))}';
	    document.window.scrollBy(0, 0);
	    style.parentNode.removeChild(style);

	    while (document._qsa.length) {
	      element = document._qsa.shift();
	      element.style.removeAttribute('x-qsa');
	      elements.push(element);
	    }
	    document._qsa = null;
	    return elements;
	  };
	}
	if (!document.getElementsByClassName) {
	  document.getElementsByClassName = function (classNames) {
	    classNames = String(classNames).replace(/^|\s+/g, '.');
	    return document.querySelectorAll(classNames);
	  };
	}
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
  // selection engine
	var instance = null;
	function engine( selector, context ){
		if ( !instance ){
    	instance = new engine.fn.find(selector, context);
		}
		return instance.find(selector, context);
  };
  // expose engine
	if ( typeof define === "function" && define.amd ) {
    define(function() {
			return engine;
    });
	}
	else{ window.engine = window._ = engine; }
	// version
	engine.version = '0.3.0';
	// extend 
	engine.extend = function(out){
	  out = out || {};
	  for (var i = 1; i < arguments.length; i++) 
		{
	    var obj = arguments[i];
	    if ( !obj ){
	      continue;
			}
			for (var key in obj) {
	      if (obj.hasOwnProperty(key)) {
	        if (typeof obj[key] === 'object'){
	          engine.extend(out[key], obj[key]);
	        }
					else
					{
	          out[key] = obj[key];
					}
	      }
	    }
	  }
	  return out;
	};
	// chain
	engine.chain = function(){
    // add fns to array
    for (var key in engine.fn) {
      if (engine.fn.hasOwnProperty(key) && isNaN(key))
        engine.selection[key] = engine.fn[key];
    }
		// return selection
		return engine.selection;
	};
	// set prototype
	engine.fn = engine.prototype = {
		//init
		find: function(selector, context)
		{
			// if no selector is present
			if( !selector ){ return engine.fn; }
			// add selection var
			engine.selection = [];
			// check context
			if( typeof(context) === "object" && context[0] !== undefined && context[0].nodeType ) {
				context.forEach(function(element){
					if(element.matches(selector)){
						engine.selection.push(element);
					}
				});
				return engine.chain();
			}else if( typeof(context) === "object" && context.nodeType ){
				context = context;
			}else if( typeof(context) === "string" ){
				context = _(context)[0];
			}else{
				context = document;
			}
			// traverse DOM
      if ( typeof selector === "string" ){
        selector = selector.trim();
        var singleSelector =/^[.|#][a-z0-9-_]+$/i.test(selector);
        // get id
        if( selector[0] === '#' && singleSelector === true){
					engine.selection[0] = document.getElementById(selector.slice(1));
				// get class	
        } else if( selector[0] === '.' && singleSelector === true){
          engine.selection = Array.prototype.slice.call(context.getElementsByClassName(selector.slice(1)),0);
				// else
				}else{
          selector = context.querySelectorAll(selector);
          for (var i = 0; i < selector.length; i++ ) {
            engine.selection[ i ] = selector[ i ];
          }
        }
      }
      // if a node is passed
      else if ( selector.nodeType ){
        engine.selection[0] = selector;
      }
      // if a nodelist is passed
      else if ( typeof(selector) === "object" && selector[0] !== undefined && selector[0].nodeType ) {
        for (var i = 0; i < selector.length; i++ ) {
          engine.selection[ i ] = selector[ i ];
        }
      }
			// keep chain going
			return engine.chain();

    },
		// add to selection
		add: function(items)
		{
			// current selection
			var sel = this;
			
			if( typeof(items) === 'string' || (typeof(items) === 'object' && items.nodeType) ){
				items = engine.fn.find(items);
			}
			
			items.forEach(function(item){
				sel.push(item);
			});
			return sel;
		},
		// remove to selection
		not: function(items)
		{
			// current selection
			var sel = this;
			
			if( typeof(items) === 'string' || (typeof(items) === 'object' && context.nodeType) ){
				items = engine.fn.find(items, sel);
			}
			
			items.forEach(function(item){
				var index = sel.indexOf(item);
				sel.splice(index, 1);
			});
			
			return sel;
		}
  };	
}(window, document, window.define));

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
		// Module children
		engine.fn.children = function(selector, maxLvl){
			engine.selection = [];
		  this.forEach(function(el){
				var children = el.children, id = domLevel = level = 0, p = undefined,
				findChild = function( children, theparatent )
				{
					var leveled = false;
					if( children !== undefined && (maxLvl === undefined || maxLvl === 0 || maxLvl === false || maxLvl > level ) )
					{
	          domLevel++;
	          for(var i = 0; i < children.length; i++ ){
							if(selector === undefined || selector === false || children[i].matches(selector)){
								if( leveled == false )
								{
									level++;
									leveled = true;
								}
	              children[i].prototype = {
	              	domLevel: domLevel,
									level: level,
									id: id++
	              };
								if( theparatent )
								{
									children[i].prototype.parent = theparatent.parent;
									children[i].prototype.parentId = theparatent.id;
									children[i].prototype.domParent = theparatent.domParent;
								}
								p = children[i];
								// check if child is in array
								if(engine.selection.indexOf(children[i]) === -1){
									engine.selection.push(children[i]);
								}
							}
							findChild(children[i].children, {'parent':p, 'id':(!p ? undefined : p.prototype.id),'domParent': children[i]});
						}
						// level within selected elements
						if(leveled === true){
							p = p.prototype.parent;
							level--;
							leveled = false;
						}
						// level in actual dom structure
		        domLevel--;
					}
	      };
	      findChild(children, {'parent': undefined, 'domParent': el});
			});
			// return a chainable engine object
			return engine.chain();
		};
		return engine;
	});
//	
}(window, window.define));
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
(function(define, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// removeEvent	
		engine.fn.off = function(event, eventHandler){
			if(event !== undefined)
			{
				if( eventHandler !== undefined )
				{
					this.forEach(function(el, i){
						el.removeEventListener(event, eventHandler, false);
					});
				}
				else
				{
					this.forEach(function(el, i){
						if( ('events' in el) && (event in el['events']) )
						{
							el['events'][event].forEach(function(ev, l){
			 					el.removeEventListener(event, ev, false);
			 				});
						}
					});
				}
			}
			else
			{
				this.forEach(function(el, i){
					if( 'events' in el )
					{
						event.split(" ").forEach(function(name){
							for(event in el['events'])
							{
								el['events'][event].forEach(function(ev, l){
				 					el.removeEventListener(event, ev, false);
				 				});
							}
						});
					}
				});
			}
			return this;
		};
		return engine;
	});
//	
}(window.define));
(function(define, undefined){
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine"], function(engine){
		// Module: each - loops through selections
		engine.fn.each = function( fn ){
			if( typeof(fn) === 'function' && this.length > 0){
			  this.forEach(function(el, i){
					fn.call(el,el, i);
			  });
			}
			return this;
		};
		return engine;
	});
//	
}(window.define));
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
/*
 * Sortable & nestable - based on html5 drag & drop api
 *
 * Copyright 2014, Lukas Oppermann
 * Released under the MIT license.
 */
(function(window, define, undefined){
	// set to strict in closure to not break other stuff
  'use strict';
	// fallback for define
	if ( typeof define !== "function" || !define.amd ) {
		define = function(arr, fn){
			fn.call(window, window.engine);
		};
	}
	// export module
	define(["engine/engine","engine/functions/children","engine/functions/class","engine/functions/css","engine/functions/parent","engine/functions/on","engine/functions/off","engine/functions/each","engine/functions/create","engine/functions/trigger"], function(_){
		// Module:sortable
		_.fn.sortable = function(opts){
			
			
			// check for dnd support
			var dndtest = document.createElement('div');
			if( ( ('draggable' in dndtest) || ('ondragstart' in dndtest && 'ondrop' in dndtest) ) === false ){
				console.log('HTML5 drag and drop is not supported in your browser.');
				return {'error':'HTML5 drag and drop is not supported in your browser.'};
			}
			
			
			// cast opts into string
			var method = String(opts);
			
			
			// merge options
			opts = _.extend({
				connectWith: false,
				item: 'li',
				listType: 'ul',
				itemType: 'li',
				grid: false,
				placeholderClass: 'sortable-placeholder',
				sortableClass: 'is-dragging',
				ghost: 'sortable-ghost',
				forcePlaceholderSize: 'height',
				forceGhostSize: true,
				noDragClass: '.js-not-draggable',
				nestDistance: 50,
				level: 0,
				sortableParentClass: 'js-sortable-parent',
				makeGhost: function(original, opts){
					return _.create('<div id="sortableGhost" class="'+opts.ghost+'">'+_.create(original.cloneNode(true),true)+'</div>');
				}
			},opts);

			// define variables gloabl for sortables
			var _dragging, _ghost, draggedOn,
					_placeholder = _.create('<' + opts.itemType + ' id="sortablePlaceholder" class="'+ opts.placeholderClass +'">');
			
			// enable, disable, destroy
			this.forEach(function(el, i){
				// setup
				var _sortable = _(el);
				_sortable.addClass(opts.sortableParentClass);
				
				// test for method to enable / disable sortable
				if (/^enable|disable|destroy$/.test(method)) {
					var _items =_sortable.children(_sortable[0].getAttribute('data-items')),
							_handles =_sortable.children(_sortable[0].getAttribute('data-handles')).each(function(item){
								if( method == 'enable' ){
									item.setAttribute('draggable', true);
								}else{
									item.removeAttribute('draggable');
								}
							});
							
					// if destroy
					if (method === 'destroy') {
						_sortable[0].removeAttribute('data-connectWith');
						_sortable[0].removeAttribute('data-items');
						_sortable[0].removeAttribute('data-handles');
						_sortable[0].removeAttribute('data-itemtype');
						_sortable[0].removeAttribute('data-listtype');
						_items.off('dragstart dragend dragover dragenter drop');
						_handles.off('selectstart');
					}
				}
				
				
				// serialize
				else if( method === 'serialize' ){
					
				}
				
				
				// initialize
				else
				{
					// set list & item type
					if( /^ul|ol$/i.test(el.tagName) ){
						opts.itemType = 'li';
						opts.listType = el.tagName.toLowerCase();
					}
					
					// set item & handler data to list
					_sortable[0].setAttribute('data-itemtype', opts.itemType);
					_sortable[0].setAttribute('data-listtype', opts.listType);
					_sortable[0].setAttribute('data-connectwith', opts.connectWith);
					_sortable[0].setAttribute('data-items', opts.item);
					_sortable[0].setAttribute('data-handles', opts.handle ? opts.handle : opts.item);
					
					// store items & enable
					_items =_sortable.children(_sortable[0].getAttribute('data-items')),
					// activate and store handles
					_handles =_sortable.children(_sortable[0].getAttribute('data-handles')).not(opts.noDragClass).each(function(handle){
						// set draggable true
						handle.setAttribute('draggable', true);
						// Fix for IE not supporting dnd on most elements
						// Long story here: http://stackoverflow.com/questions/5500615/internet-explorer-9-drag-and-drop-dnd/8986075#answer-8986075
						if( handle.tagName !== 'IMG' && !handle.hasAttribute('href') )
						{
							_(handle).on('selectstart', function() {
								this.dragDrop && this.dragDrop();
								return false;
							});
						}
					});
					// Handle drag events on draggable items
					_items.on('dragstart', function(e) {
						console.log(opts);
						// so as to only run stuff on dragged item
						e.stopPropagation();
						
						// dnd needs this to work
						e.dataTransfer.effectAllowed = 'move';
						e.dataTransfer.setData('Text', this.getAttribute('data-id')); // required otherwise doesn't work
						
						// store reference
						_dragging = _(this);
						_dragging.element = this;
						_dragging.parent = _dragging.addClass(opts.sortableClass).parent('.'+opts.sortableParentClass);
						_dragging.index = Array.prototype.indexOf.call(_dragging.parent.children(false, 1), this);
						// store width / height
						_dragging.width 	= ( _dragging.css('width')+_dragging.css('padding-left')+_dragging.css('padding-right'))+'px';
						_dragging.height = ( _dragging.css('height')+_dragging.css('padding-top')+_dragging.css('padding-bottom'))+'px';
							
						// create ghost
						_('body').append(opts.makeGhost(this,opts));
						// cache selection
						_ghost = _('#sortableGhost');

						// if force size
						if( opts.forceGhostSize !== false && opts.forceGhostSize !== "false" )
						{
							var css = {};
							opts.forceGhostSize !== 'width' ? css.height = _dragging.height : '';
							opts.forceGhostSize !== 'height' ? css.width = _dragging.width : '';
							
							_ghost.css(css);
						}
						
						// save offsets
						_ghost.mouseOffsetX = parseInt(e.pageX-this.offsetLeft);
						_ghost.mouseOffsetY = parseInt(e.pageY-this.offsetTop);

						// set ghost as DragImage
						e.dataTransfer.setDragImage(_ghost[0], _ghost.mouseOffsetX, _ghost.mouseOffsetY);
						// hide ghost with timeout
						window.setTimeout(function(){
							// remove GhostElement once ghost is initiated
							_ghost.remove();
							// add placeholder
							_dragging.before(_placeholder);
							// remove dragging element
							_dragging.remove();
							
							// cache selection
							_placeholder = _('#sortablePlaceholder');
							
							// if force size
							if( opts.forceplaceholdersize !== false && opts.forceplaceholdersize !== "false" )
							{
								var css = {};
								opts.forceplaceholdersize !== 'width' ? css.height = _dragging.height : '';
								opts.forceplaceholdersize !== 'height' ? css.width = _dragging.width : '';
							
								_placeholder.css(css);
							}
							
							// add dragover to placeholder
							_placeholder.on('dragover', function(e){
								e.preventDefault();
								e.dataTransfer.dropEffect = 'move';
								return false;
							});
						},1);
						
					},0);


					_items.on('drag',function(e){
						// so as to only run stuff on dragged item
						e.stopPropagation();
						
						if( !offsets || !offsets.pageX || !offsets.pageY || offsets.pageX != e.pageX || offsets.pageY != e.pageY ){
							// store X & Y pos
							var offsets = {
								pageX: e.pageX,
								pageY: e.pageY
							};
							if( draggedOn != undefined && draggedOn != null && this != draggedOn )
							{
								_placeholder.fn = setTimeout(function(){
									if( draggedOn ){
										
										
										if( opts.grid === true || opts.grid === "true" ){
											// grid mode
											offsets.difference = offsets.pageX-(draggedOn.offsetLeft+(_(draggedOn).css('width')/2));
										}else{
											// list mode
											offsets.difference = offsets.pageY-(draggedOn.offsetTop+(_(draggedOn).css('height')/2));
										}


										// insert before
										if( offsets.difference < 0 )
										{
											_(draggedOn).before(_placeholder[0]);
										}
										// insert after
										else
										{
											_(draggedOn).after(_placeholder[0]);
										}
										
										
									}
								},50);
							}
							
						}
					},1);
					
					// Handle dragenter
					_items.on('dragenter',function(e){
						// so as to only run stuff on dragged item
						e.stopPropagation();
						if( _dragging != undefined && this != _dragging[0] && _items.indexOf(this) != -1 && (_dragging.parent[0] === _(this).parent('.'+opts.sortableParentClass)[0]
						 		|| _(this).parent('.'+opts.sortableParentClass)[0].getAttribute('data-connectwith') === _dragging.parent[0].getAttribute('data-connectwith')
						)){
							draggedOn = this;
						}
					},0);
					
					// Handle dragend events
					_items.on('dragend', function(e) {
						// stop drag to fire on mouseup
						clearTimeout(_placeholder.fn);
						
						// so as to only run stuff on dragged item
						e.stopPropagation();
						
						// remove class
						_dragging.removeClass(opts.sortableClass);
						
						// add element
						_placeholder.before(_dragging.element);
						
						// remove placeholder with delay to not be remove before element is added
						window.setTimeout(function(){
							_placeholder.remove();
						},1);

						// sort update
						_sortable.trigger('sortupdate',{'item': this, 'parent':_sortable, 'prevParent':_dragging.parent, 'prevIndex':_dragging.index});

						// rest dragging & draggedOn
						_dragging = null;
						draggedOn = null;
					});

				}
			});
			
			return this;
		};
		// return engine
		return _;
	});
//	
}(window, window.define));
$(document).ready(function(){

  // $('body').on('mouseenter', '.js-editor-section-dragHandler', function(){
  //   $(this).parents('.js-editor-section').addClass('drag-is-active');
  // }).on('mouseleave', '.js-editor-section-dragHandler', function(){
  //   $(this).parents('.js-editor-section').removeClass('drag-is-active');
  // });

  // $('body').on('mouseenter', '.js-fragment', function(){
  //   $(this).parents('.js-editor-section').addClass('child-is-active');
  // }).on('mouseleave', '.js-fragment', function(){
  //   $(this).parents('.js-editor-section').removeClass('child-is-active');
  // });
  //
  // $('body').height($(window).height());
  // $('.content-body').sortable({
  //   item: '.js-editor-section',
  //   forcePlaceholderSize: true,
  //   handle: '.js-editor-section-dragHandler'
  // });

engine('ul.parent').sortable({
  handle: "span"
});
engine('ul.child').sortable({connectWith:'ul.child'});


//     $('.editor-inner-section').sortable({
//       item: '.column',
//       forcePlaceholderSize: true,
//       connectWith: '.editor-inner-section'
//     });
//
//   $('.mark').each(function(){
//       var yo = CodeMirror.fromTextArea($(this).find('.textarea')[0], {
//         mode: 'gfm',
//         theme: 'mark',
//         content: $(this).find('.textarea').text()
//       });
//
//       yo.on("focus", function(cm){
//         console.log(cm);
//         $(cm).parents('.js-fragment').addClass('is-focused');
//       });
//
//       yo.on("blur", function(cm){
//         $(cm).parents('.js-fragment').removeClass('is-focused');
//       });
//
//   });
//
//   // $('.mark').attr('draggable', true);
//
//   // $('.dragger').on('click', function(){
//   //   $(this).hide();
//   //
//   // }).on('doubleclick', function(){
//   //   alert('now');
//   // });
//
//   $('.dragger').click(function(e) {
//     var _that = $(this);
//     setTimeout(function() {
//         var dblclick = parseInt(_that.data('double'), 10);
//         if (dblclick > 0) {
//             _that.data('double', dblclick-1);
//         } else {
//             // singleClick.call(that, e);
//             _that.hide();
//         }
//     }, 300);
//   }).dblclick(function(e) {
//       $(this).data('double', 2);
//       // doubleClick.call(this, e);
//       alert('now');
//   });
//
// $('.mark').on('mousedown', function(e) {
//   this.t = setTimeout(function() {
//     alert('now2');
//   }, 500);
// }).on('mouseup', function(e){
//   clearTimeout(this.t);
// }).on('mousemove', function(e){
//   clearTimeout(this.t);
// });

});
