/*
 * Serialize
 *
 * @description: Serializer for HTML-Structures
 *
 * Copyright 2014, Lukas Oppermann
 * Released under the MIT license.
 */
// fallback for define if no amd is present
if ( typeof define !== "function" || !define.amd ) {
	var define = function(arr, fn){
		fn.call(window, window.engine);
	};
}
// export module
define(["engine/engine", "engine/functions/children", "engine/functions/each"], function(engine){
	// fn to get all data attributes
	var getDataAttributes = function(el) {
    var data = {};
    [].forEach.call(el.attributes, function(attr) {
      if (/^data-/.test(attr.name)) {
        data[attr.name.substring(5)] = attr.value;
      }
    });
    return data;
	}
	// serializer
	engine.fn.serialize = function( opts ){
		// defaults
		opts = _.extend({
			'item': '.block',
			'level': 0,
			// items to be removed from json
			'removeItems': [
				'parent',
				'parentId',
				'id',
				'level'
			],
			// serialize fn
			'serialize': function( item, obj ){
				return {};
			},
			// result fn
			'result' : function( map ){
				var m = [];
				m = JSON.parse(JSON.stringify(map));
				var content = [];
				for (var id in m) 
				{
			    var parent = m[m[id].parentId];
			    if (parent) {
			    	parent.children = parent.children || [];
						parent.children.push(opts.removeFromItem(m[id])); // add reference to item
			    } else { // root
						content.push(opts.removeFromItem(m[id]));
			    }
				}
				m = [];
				return content;
			},
			'removeFromItem': function( item ){
				opts.removeItems.forEach(function(key){
					delete item[key];
				});
				return item;
			}
		}, opts);
		
		// function
		var map = [];
		engine(this).children(opts.item, opts.level).each(function(){
			// get base info
			var item = _.extend({
					level: this.prototype.level,
					id: this.prototype.id,
					parentId: this.prototype.parentId
				}, 
				// get all data- attributes
				getDataAttributes(this)
			);
			// custom serialize fn
			item = _.extend(item, opts.serialize(this, item));
			// add item to map
			map[item.id] = item;
		});
		// return result
		return JSON.stringify(opts.result(map));
	};
	//
	return engine;
});