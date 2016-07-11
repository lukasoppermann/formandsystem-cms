(function(window, document){
// get all elements
var elements = document.querySelectorAll('[data-autosubmit-form]');
// update function
var update = function(url, updateData, successFn, errorFn){
    fetch(url, {
        credentials: 'same-origin',
        headers: {
           'Content-Type': 'application/x-www-form-urlencoded',
           'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
        },
        method: "PATCH",
        body: JSON.stringify(updateData)
    }).then(function(response) {

    }).catch(function(error) {
        errorFn();
    });
};

var errorFn = function(){
    console.log('ERROR');
};
// loop through elements
Array.prototype.forEach.call(elements, function(el, i){
    // get delay
    var delay = el.getAttribute('data-autosubmit-form');
    // update on keyup after x seconds
    el.addEventListener('keyup', function(){
        if (this.timeoutId){
            window.clearTimeout(this.timeoutId);
        }
        this.timeoutId = window.setTimeout(function () {
            update('',{},'',errorFn);
        }, delay);
    });
    // update on blur an remove timed update
    el.addEventListener('blur', function(){
        if (this.timeoutId){
            window.clearTimeout(this.timeoutId);
        }
        update('',{},'',errorFn);
    });
});
})(window, document);
