var results = 'tests/frontend/results/';
var page = require('webpage').create();
page.viewportSize = { width: 1024, height: 760 };
// page.clipRect = { width: 1024, height: 760 };
page.open('http://google.com');
page.onLoadFinished = function() {
  
   page.render('tests/frontend/results/googleScreenShot' + '.png');
   phantom.exit();
};

// , function () {
//     var title = page.evaluate(function () {
//       return document.title;
//     });
//     setTimeout(function() {
//       page.render(results+'test_'+(Date.now() / 1000 | 0)+'/yo'+ ".png");
//         // Do other things here...
//       phantom.exit();
//     }, 2000);
// }
