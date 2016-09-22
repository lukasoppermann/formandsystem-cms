var elements = document.querySelectorAll('.toggable');

Array.prototype.forEach.call(elements, function(el, i){
    el.querySelector('.js-toggler').addEventListener('click', function(item){
        item = item.target;
        if(el.classList.contains('is-toggled')){
            el.classList.remove('is-toggled');
            item.innerHTML = item.getAttribute('data-expand');
        }
        else {
            el.classList.add('is-toggled');
            item.innerHTML = item.getAttribute('data-condense');
        }

    });
});
