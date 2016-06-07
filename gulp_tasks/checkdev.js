//-----------------------
// Gulp check tasks
var checkPages = require("check-pages");
require('gulp').task("checkDev", function(callback) {
  var options = {
    pageUrls: [
      'http://cms.formandsystem.app/',
      'http://cms.formandsystem.app/pages',
      'http://cms.formandsystem.app/pages/new-item-509153036'
    ],
    checkLinks: true,
    linksToIgnore: [
      'http://localhost:8080/broken.html'
    ],
    noEmptyFragments: true,
    noLocalLinks: true,
    noRedirects: true,
    onlySameDomain: true,
    preferSecure: true,
    queryHashes: true,
    checkCaching: true,
    checkCompression: true,
    summary: true,
    terse: true,
    maxResponseTime: 200,
    userAgent: 'custom-user-agent/1.2.3'
  };
  checkPages(console, options, function(err, count) {
    if (err) {
      console.log("Error object: " + err);
    }
    console.log("Error count: " + count);
  });
});
