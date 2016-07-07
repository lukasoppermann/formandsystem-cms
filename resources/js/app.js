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
        theme: "mark",
        mode: {
            name: "gfm",
            highlightFormatting: true
        },
        lineWrapping: true,
    });
});

var formsubmit = function(){
    var elements = document.querySelectorAll('[data-submit-form]');
    Array.prototype.forEach.call(elements, function(el, i){
        el.addEventListener('click', function(){
            var element = document.querySelector('[name='+el.getAttribute('data-submit-form')+']');
            element.querySelector('[type=submit]').click();
        });
    });
}

var navSortables = sortable('.js-sortable', {
    items: '.js-sortable-item',
    forcePlaceholderSize: true,
    placeholder: '<li class="c-navigation__item-placeholder"></li>'
});

navSortables.forEach(function(el){
    el.addEventListener('sortupdate', function(e) {
        e.detail.startParent.items.forEach(function(draggedItem){
            if(draggedItem.hasChanged === true){
                var url = "http://formandsystem-cms.dev/pages/"+draggedItem.item.getAttribute('data-id');

                fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                       'Content-Type': 'application/x-www-form-urlencoded',
                       'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    method: "PATCH",
                    body: JSON.stringify({
                        'collection': e.detail.startParent.item.getAttribute('data-collection-id'),
                        'position':draggedItem.position
                    })
                }).then(function(response) {
                });
            }
        });
    });
});
