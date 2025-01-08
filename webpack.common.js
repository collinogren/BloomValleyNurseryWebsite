const path = require('path');

module.exports = {
  entry: {
    app: './js/hamburger.js',
  },
  output: {
    path: path.resolve(__dirname, 'dist'),
    clean: true,
    filename: './js/hamburger.js',
  },
};
