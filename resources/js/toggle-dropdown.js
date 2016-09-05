(function(window, document){
    ready(function(){
        // get all elements
        forEach(document.querySelectorAll('[data-js-toggle-dropdown]'), function(el, i){
            var dropdown = el.parentNode.querySelector('[data-js-dropdown]');

            el.addEventListener('click', function(e){
                e.preventDefault();
                if(dropdown.classList.contains('is-active')){
                    this.classList.remove('is-active');
                    dropdown.classList.remove('is-active');
                } else {
                    this.classList.add('is-active');
                    dropdown.classList.add('is-active');
                }
            });
            el.addEventListener('blur', function(e){
                this.classList.remove('is-active');
                dropdown.classList.remove('is-active');
            });
        });

    });
}(window, document));
