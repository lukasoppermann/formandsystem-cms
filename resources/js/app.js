
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

            // document.querySelector('[data-fragment-form="'+this.getAttribute('data-image-onchange')+'"]').submit();
            var parent = document.querySelector('[data-fragment-form="'+this.getAttribute('data-image-onchange')+'"]');
            parent.querySelector('.o-file__label').innerHTML = 'Uploading ...';
            var reader  = new FileReader();
            reader.readAsDataURL(this.files[0]);

            var formData  = new FormData(parent);
            formData.append('fragment', parent.querySelector('[name=fragment]').value);
            formData.append('file', reader.result);

            fetch(parent.getAttribute('action'), {
                credentials: 'same-origin',
                headers: {
                //    'Content-Type': 'multipart/form-data',
                   'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                method: "POST",
                body: formData
            }).then(function(response) {
                if(response.status < 300 ){
                    response.json().then(function(result){
                        var result = result.data;
                        parent.classList.remove('is-empty');
                        parent.querySelector('.o-fragment__image').setAttribute('src', parent.querySelector('.o-fragment__image').getAttribute('data-base-url')+result.attributes.filename);
                        parent.querySelector('.o-fragment__image').setAttribute('data-image-id', result.id);
                    });
                }
                else {
                    parent.classList.add('is-empty');
                    parent.querySelector('.o-file__label').innerHTML = 'Upload image';
                }
            }).catch(function(response) {
                parent.classList.add('is-empty');
                parent.querySelector('.o-file__label').innerHTML = 'Upload image';
            });
        });
    });


    // onchange submit image
    var image_delete = document.querySelectorAll('.c-fragment__image-delete-button');
    Array.prototype.forEach.call(image_delete, function(el, i){
        el.addEventListener('click', function(e){
            e.preventDefault();
            var parent = document.querySelector('[data-fragment-form="'+this.getAttribute('data-parent-form')+'"]');
            fetch(parent.getAttribute('action')+'/'+parent.querySelector('.o-fragment__image').getAttribute('data-image-id'), {
                credentials: 'same-origin',
                headers: {
                //    'Content-Type': 'multipart/form-data',
                   'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                method: "DELETE"
            }).then(function(response) {
                if(response.status < 300 ){
                    parent.classList.add('is-empty');
                    parent.querySelector('.o-fragment__image').setAttribute('src', '');
                    parent.querySelector('.o-file__label').innerHTML = 'Upload image';
                }
            }).catch(function(response) {
            });
        });
    });
});
