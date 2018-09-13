var config = {
  test:{
    hub: 'http://localhost:4444/wd/hub',
    website:'http://localhost:8000',
    output_dir : 'output',
    pages : [
      'home': {
        'location':'',
        'alias':'',
        'name':''
      }
    ]
  }
};

module.exports = config;