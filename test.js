var express = require('express');
var app = express();

app.get('/', function (req, res) {
  res.send('Hello World!');
});

<<<<<<< HEAD
var server = app.listen(3000, function () {
=======
var server = app.listen(80, function () {
>>>>>>> ab129641f4ff16644f7b47241fbb8086ad93bbd9
  var host = server.address().address;
  var port = server.address().port;

  console.log('Example app listening at http://%s:%s', host, port);
});