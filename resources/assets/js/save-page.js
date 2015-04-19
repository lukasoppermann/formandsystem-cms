var fragmentFns = {
  text: function() {
    var editor = editors[this.querySelector('.mark').getAttribute('data-mark')];
    return editor.getValue('');
  }
};

var savePage = function() {

  var i = 0;
  var columns = nestable('.editor-inner-section').serialize(function() {

    var fragment = this.querySelector('.js-fragment');
    return {
      offset: parseInt(this.getAttribute('data-offset')),
      column: parseInt(this.getAttribute('data-column')),
      fragmentId: parseInt(fragment.getAttribute('data-fragment-id')),
      fragmentKey: fragment.getAttribute('data-fragment-key'),
      fragmentType: fragment.getAttribute('data-fragment-type'),
      fragmentContent: fragmentFns[fragment.getAttribute('data-fragment-type')].call(fragment)
    };
  });

  var serialized = nestable('.content-body').serialize(function() {
    return {
      children: columns[i++],
      class: this.querySelector("[data-js='additional-classes']").value,
      link: this.querySelector("[data-js='section-link']").value
    };
  });

  console.log('save-page.js needs error handling for when not menu item is active');

  var page = function() {
    var menuItem = document.querySelector('.menu-item.js-is-active');

    if (menuItem === undefined) {
      return {};
    }

    var menuData = {
      menu_label: menuItem.querySelector('.menu-link-text').textContent,
      link: menuItem.parentNode.querySelector('.link-input').value
    };

    return JSON.stringify(menuData);
  }();

  $.ajax({
    url: '/pages/'+document.querySelector('[data-page]').getAttribute('data-page-id'),
    type: 'PUT',
    data: 'page='+page +'&data='+JSON.stringif y(serialized[0])+'&_token='+$('meta[name="_token"]')[0].getAttribute('content'),
    dataType: 'text'
  });
};
