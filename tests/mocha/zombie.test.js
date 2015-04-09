/* jshint expr: true */

var assert = require("chai").assert,
	Browser = require("zombie");

describe("The Landing page", function() {
	var server, browser, todoUrl;
  const browser = new Browser();
  
	todoUrl = "http://ebike-connect.com";

	it("should show the login page to begin", function(done) {
		browser.visit(todoUrl, function() {
			assert(browser.text("#page-heading") === "Simple Todo",
				"page heading must match");
			assert(browser.text("#login-heading") === "Welcome to Simple Todo",
				"login heading must exist and match");

			// done with test
			done();
		});
	});

});
