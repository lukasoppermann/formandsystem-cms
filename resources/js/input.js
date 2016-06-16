// input
var inputs = function(){
    var elements = document.querySelectorAll('[data-check-empty]');
    Array.prototype.forEach.call(elements, function(el, i){
        if(el.value == ""){
            el.classList.add('is-empty');
        }else{
            el.classList.remove('is-empty');
        }
        el.addEventListener('keyup', function(){
            if(el.value == ""){
                el.classList.add('is-empty');
            }else{
                el.classList.remove('is-empty');
            }
        });
    });
};
inputs();
