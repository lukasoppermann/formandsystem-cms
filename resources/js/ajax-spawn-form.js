(function(window, document){
    // get all elements
    var elements = document.querySelectorAll('[data-spawn-form]');

    var update = function(url, updateData, successFn, errorFn, element){
        fetch(url, {
            credentials: 'same-origin',
            headers: {
               'Content-Type': 'application/x-www-form-urlencoded',
               'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
            },
            method: element.getAttribute('method'),
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

    // loop through elements
    Array.prototype.forEach.call(elements, function(el, i){
        var url = el.getAttribute('action');
        // only run if valid url available
        if(url !== null){
            el.querySelector('[data-ajax-form-submit]').addEventListener('click', function(e){
                e.preventDefault();

                update(url,
                    {
                        'data': {
                            'type': el.querySelector('[name=type]').value,
                            'meta': {
                                'classes' : el.querySelector('[name=classes]').value
                            },
                            'parentId': el.querySelector('[name=parentId]').value,
                            'parentType': el.querySelector('[name=parentType]').value,
                        }
                    },
                    function(){},
                    function(){},
                    el
                );
            });
        }
    });

})(window, document);
