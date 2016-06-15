// Toggle dialog js
var elements = document.querySelectorAll('[data-open-dialog=edit-collection]');
Array.prototype.forEach.call(elements, function(el, i){
    el.addEventListener('click', function(){
        // show dialog
        document.querySelector('[data-dialog]').classList.remove('is-hidden');

        fetch(el.getAttribute('data-link'), {
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.text()
        }).then(function(dialog) {
            document.querySelector('[data-dialog-loading]').classList.add('is-hidden');
            document.querySelector('[data-dialog-content]').innerHTML = dialog;
        });
    });
});

document.querySelector('[data-close-dialog]').addEventListener('click', function(){
    document.querySelector('[data-dialog]').classList.add('is-hidden');
    document.querySelector('[data-dialog-content]').innerHTML = "";
    document.querySelector('[data-dialog-loading]').classList.remove('is-hidden');
});
