
(function(document,window){window.ready=function(fn){if(document.readyState!='loading'){fn();}else{document.addEventListener('DOMContentLoaded',fn);}}}(document,window));(function(document,window){var styleText='::-moz-focus-inner{border:0 !important;}:focus{outline: none !important;';var unfocus_style=document.createElement('STYLE');window.unfocus=function(){document.getElementsByTagName('HEAD')[0].appendChild(unfocus_style);document.addEventListener('mousedown',function(){unfocus_style.innerHTML=styleText+'}';});document.addEventListener('keydown',function(){unfocus_style.innerHTML='';});};unfocus.style=function(style){styleText+=style;};unfocus();})(document,window);var forEach=function(collection,callback,scope){if(Object.prototype.toString.call(collection)==='[object Object]'){for(var prop in collection){if(Object.prototype.hasOwnProperty.call(collection,prop)){callback.call(scope,collection[prop],prop,collection);}}}else{for(var i=0,len=collection.length;i<len;i++){callback.call(scope,collection[i],i,collection);}}};(function(window,document){var _config={class:'is-empty'};var _nodeList;var _toggleClass=function(element){if(element.value===''){element.classList.add(_config.class);}else{element.classList.remove(_config.class);}}
var isempty=function(nodeList,userConfig){if(typeof nodeList!="undefined"&&typeof userConfig!="undefined"&&NodeList.prototype.isPrototypeOf(_nodeList)){Array.prototype.forEach.call(_nodeList,function(el){_toggleClass(el);});}
if(!NodeList.prototype.isPrototypeOf(nodeList)){userConfig=nodeList||{};nodeList=document.querySelectorAll('textarea, input:not([type=hidden]):not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"])');}
_nodeList=nodeList;for(var attrname in userConfig){_config[attrname]=userConfig[attrname];}
Array.prototype.forEach.call(_nodeList,function(el){window.setTimeout(function(){_toggleClass(el);},100);el.addEventListener('keyup',function(){_toggleClass(el);});el.addEventListener('blur',function(){_toggleClass(el);});});return isempty;};window.isempty=isempty;}(window,document));(function(window,document){ready(function(){forEach(document.querySelectorAll('[data-js-toggle-dropdown]'),function(el,i){var dropdown=el.parentNode.querySelector('[data-js-dropdown]');el.addEventListener('click',function(e){if(dropdown.classList.contains('is-active')){this.classList.remove('is-active');dropdown.classList.remove('is-active');}else{this.classList.add('is-active');dropdown.classList.add('is-active');}});el.addEventListener('blur',function(e){setTimeout(function(){el.classList.remove('is-active');dropdown.classList.remove('is-active');},200);});});});}(window,document));ready(function(){isempty();unfocus.style('box-shadow: none !important;');setTimeout(function(){isempty();},500);});
//# sourceMappingURL=app.js.map