// ----------------------
//
// NAVIGATION sortable
//
var navSortables = sortable('.js-sortable', {
    items: '.js-sortable-item',
    forcePlaceholderSize: true,
    placeholder: '<li class="c-navigation__item-placeholder"></li>'
});

navSortables.forEach(function(el){
    el.addEventListener('sortupdate', function(e) {
        e.detail.startParent.items.forEach(function(draggedItem){
            if(draggedItem.hasChanged === true){
                var url = e.detail.startParent.item.getAttribute('data-patch-url')+draggedItem.item.getAttribute('data-id');
                var parentID = e.detail.startParent.item.getAttribute('data-collection-id');
                fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                       'Content-Type': 'application/x-www-form-urlencoded',
                       'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    method: "PATCH",
                    body: JSON.stringify({
                        'collection': parentID,
                        'position':draggedItem.position
                    })
                }).then(function(response) {
                });
            }
        });
    });
});
