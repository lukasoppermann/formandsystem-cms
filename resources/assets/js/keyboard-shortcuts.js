/* -- JSHint --*/
/*keymage*/

// set scope for keymage
var scope = document.querySelector('meta[name="_scope"]').getAttribute('content') || 'global';
console.log(scope);
keymage.setScope(scope);
/*
 * Scope: Editor
 */
keymage('editor','defmod-s', savePage, {preventDefault: true});
