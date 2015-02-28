var fragmentFns = {
  text: function(){
    var editor = editors[this.querySelector('.mark').getAttribute('data-mark')];
    return editor.getValue('');
  }
};

var savePage = function() {

  var i = 0,
  columns = nestable('.editor-inner-section').serialize(function(){

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

  var serialized = nestable('.content-body').serialize(function(){
    return {
      children: columns[i++],
      class: this.getAttribute('data-class'),
      link: this.getAttribute('data-link')
    };
  });

  $.ajax({
    url: '/pages/'+document.querySelector('[data-page]').getAttribute('data-page-id'),
    type: 'PUT',
    data: 'data='+JSON.stringify(serialized[0])+'&_token='+$('meta[name="_token"]')[0].getAttribute('content'),
    dataType: 'text'
  });
};
