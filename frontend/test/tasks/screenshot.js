var webdriverjs = require('webdriverjs');
try {
  config = require('./config.js');

} catch (e) {
  config = {};
}

var client = webdriverjs.remote({
  desiredCapabilities: {
    browserName: 'chrome',
    name: 'This is an example test'
  },
  host: config.hub,
}).init();

client
  .url('http://google.com')
  .setValue('*[name="q"]', 'webdriverjs')
  .click('*[name="btnG"]')
  .pause(1000)
  .getTitle(function(err, title) {
    console.log(title);
  })
  .end();