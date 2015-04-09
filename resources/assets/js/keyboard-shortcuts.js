/* -- JSHint --*/
/*keymage*/

// set scope for keymage
var scope = document.querySelector('meta[name="_scope"]').getAttribute('content') || 'global';
keymage.setScope(scope);
/*
 * Scope: Editor
 */
keymage('editor','defmod-s', function(){
  APP.eventEmitter.emit('save-page');
}, {preventDefault: true});
