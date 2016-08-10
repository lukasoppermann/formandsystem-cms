function ready(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}
ready(function(){
// Toggle js
var elements = document.querySelectorAll('[data-toggle]');
Array.prototype.forEach.call(elements, function(el, i){
    el.addEventListener('click', function(){
        var elements = document.querySelectorAll('[data-target='+el.getAttribute('data-toggle')+']');
        Array.prototype.forEach.call(elements, function(el, i){
            el.classList.toggle('is-active');
        });
    });
});
// Hide js
var elements = document.querySelectorAll('[data-hide]');
Array.prototype.forEach.call(elements, function(el, i){
    el.addEventListener('click', function(){
        var elements = document.querySelectorAll('[data-target='+el.getAttribute('data-hide')+']');
        Array.prototype.forEach.call(elements, function(el, i){
            el.remove();
        });
    });
});
// Toggle dialog js
var elements = document.querySelectorAll('[data-toggle-dialog]');
Array.prototype.forEach.call(elements, function(el, i){
    el.addEventListener('click', function(){
        var elements = document.querySelectorAll('[data-target='+el.getAttribute('data-toggle-dialog')+']');
        Array.prototype.forEach.call(elements, function(el, i){
            // document.body.appendChild(el);
            el.classList.toggle('is-hidden');
        });
    });
});
// Toggle on change js
// var elements = document.querySelectorAll('[data-toggle-if-filled]');
// Array.prototype.forEach.call(elements, function(el, i){
//     el.addEventListener('keyup', function(){
//         var element = document.querySelector('[data-target='+el.getAttribute('data-toggle-if-filled')+']');
//         element.classList.add('is-active');
//     });
// });
var elements = document.querySelectorAll('.mark');
Array.prototype.forEach.call(elements, function(el, i){
    var myCodeMirror = CodeMirror.fromTextArea(el,{
        theme: 'mark',
		mode: {
			name: 'gfm',
			highlightFormatting: true
		},
		lineNumbers: false,
		addModeClass: false,
		lineWrapping: true,
		flattenSpans: true,
		cursorHeight: 1,
		matchBrackets: true,
		autoCloseBrackets: { pairs: '()[]{}\'\'""', explode: '{}' },
		matchTags: true,
		showTrailingSpace: true,
		autoCloseTags: true,
		styleSelectedText: false,
		styleActiveLine: true,
		placeholder: '',
		excludePanel: ['code'],
		tabMode: 'indent',
		tabindex: '2',
		dragDrop: false,
    });
    mark(myCodeMirror);
});
    // onchange submit image
    var elements = document.querySelectorAll('[data-image-onchange]');
    Array.prototype.forEach.call(elements, function(el, i){
        el.addEventListener('change', function(triggered){
            console.log(triggered);
            var form = document.querySelector('[data-fragment-form="'+this.getAttribute('data-image-onchange')+'"]');
            console.log(this);
            //.submit();
        });
    });
});
