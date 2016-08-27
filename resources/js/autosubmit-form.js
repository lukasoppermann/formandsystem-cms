(function(window, document){
// get all elements
var elements = document.querySelectorAll('[data-autosubmit-form]');
// update function
var update = function(url, updateData, successFn, errorFn, element){
    fetch(url, {
        credentials: 'same-origin',
        headers: {
           'Content-Type': 'application/x-www-form-urlencoded',
           'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
        },
        method: "PATCH",
        body: JSON.stringify(updateData)
    }).then(function(response) {
        if(response.status < 300 ){
            successFn(element);
        }
        else {
            errorFn(element);
        }
    }).catch(function(response) {
        errorFn(element);
    });
};

var errorFn = function(el){
    window.setTimeout(function () {
        el.parentNode.classList.remove('is-saving');
        el.parentNode.classList.add('has-failed');
        window.setTimeout(function () {
            el.parentNode.classList.remove('has-failed');
        },5000);
    }, 500);
};
var successFn = function(el){
    el.autosubmitData = el.value;
    window.setTimeout(function () {
        el.parentNode.classList.remove('is-saving');
        el.parentNode.classList.add('has-succeeded');
        window.setTimeout(function () {
            el.parentNode.classList.remove('has-succeeded');
        },5000);
    }, 500);
};
// loop through elements
Array.prototype.forEach.call(elements, function(el, i){
    // get delay
    var delay = el.getAttribute('data-autosubmit-form');
    var url = el.getAttribute('data-patch-url');
    // only run if valid url available
    if(url !== null){
        // set data on element
        el.autosubmitData = el.value;
        // update on keyup after x seconds
        el.addEventListener('keyup', function(){
            if (this.timeoutId){
                window.clearTimeout(this.timeoutId);
            }
            this.timeoutId = window.setTimeout(function () {
                el.parentNode.classList.remove('has-failed');
                el.parentNode.classList.remove('has-succeeded');
                el.parentNode.classList.add('is-saving');
                update(url,
                    {'data': el.value || '$undefined'},
                    successFn,
                    errorFn,
                    el
                );
            }, delay);
        });
        // update on blur an remove timed update
        el.addEventListener('blur', function(){
            if (this.timeoutId){
                window.clearTimeout(this.timeoutId);
            }
            // if data has changed, update
            if(el.autosubmitData !== this.value){
                el.parentNode.classList.remove('has-failed');
                el.parentNode.classList.remove('has-succeeded');
                el.parentNode.classList.add('is-saving');
                update(url,
                    {'data': el.value || '$undefined' },
                    successFn,
                    errorFn,
                    el
                );
            }
        });
    }
});
})(window, document);
