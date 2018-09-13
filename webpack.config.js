var path = require('path');
var webpack = require('webpack');

module.exports = {
  // This is the "main" file which should include all other modules
  entry: {
    home: './frontend/static/scripts/home.js'
  },
  // Where should the compiled file go?
  
  output: {
    // To the `dist` folder
    path: path.resolve(__dirname, 'backend/public/site/scripts'),
    // With the filename `build.js` so it's dist/build.js
    filename: '[name].js'
  },
  
  resolve: {
    extensions: ['.js'],
    alias: {
      'vue$': 'vue/dist/vue.common.js',
    }
  },

  module: {
    // jquery custom scrollbar
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      }
    ]
  },
  plugins: [
    //new webpack.ProvidePlugin({
    //  '$': "jquery",
    //  'jQuery': "jquery",
    //  'window.$': "jquery",
    //  'window.jQuery': "jquery"
    //}),
    //new webpack.DefinePlugin({ // <-- key to reducing React's size
    //  'process.env': {
    //    'NODE_ENV': JSON.stringify('production')
    //  }
    //}),

    //new webpack.optimize.UglifyJsPlugin(), //minify everything
    //new webpack.optimize.AggressiveMergingPlugin()//Merge chunks
  ]
}