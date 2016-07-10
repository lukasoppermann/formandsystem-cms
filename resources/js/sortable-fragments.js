// ----------------------
//
// Fragment sortable
//
var fragments = sortable('.js-sortable-fragments', {
    items: '.js-sortable-fragment-item',
    handle: '.js-sortable-fragment-item-handle',
    forcePlaceholderSize: true,
    placeholder: '<div class="c-fragment-placeholder"></div>'
});


fragments.forEach(function(el){
    el.addEventListener('sortupdate', function(e) {
        e.detail.startParent.items.forEach(function(draggedItem){
            if(draggedItem.hasChanged === true){
                var url = e.detail.startParent.item.getAttribute('data-patch-url')+draggedItem.item.getAttribute('data-id');
                fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                       'Content-Type': 'application/x-www-form-urlencoded',
                       'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    method: "PATCH",
                    body: JSON.stringify({
                        'position'      : draggedItem.position
                    })
                }).then(function(response) {
                });
            }
        });
    });
});
