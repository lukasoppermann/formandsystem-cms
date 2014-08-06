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