// [].forEach.call( document.querySelectorAll( '.menu-link' ), function ( a ) {
//   a.addEventListener( 'click', function (e) {
//     [].forEach.call(document.querySelectorAll( '.menu-item' ), function ( item ) {
//       item.classList.remove('is-active');
//       while (item) {
//         item = item.nextSibling;
//         if ( item != undefined && item.nodeType === 1)
//           break;
//       }
//       if (item != undefined && item.nodeType === 1)
//       {
//         item.classList.remove('is-active');
//       }
//     });
//     item = a.parentNode;
//     item.classList.add('is-active');
//     while (item) {
//       item = item.nextSibling;
//       if ( item.nodeType === 1)
//         break;
//     }
//
//       if (item.nodeType === 1)
//       {
//           item.classList.add('is-active');
//       }
//
//     e.preventDefault();
//   }, false );
// });
