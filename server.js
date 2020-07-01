let http = require('http').Server();
let io = require('socket.io')(http);
let Redis = require('ioredis'); 

let redis = new Redis();
redis.psubscribe('chat.*');
redis.on('pmessage', function(pattern, channel, message) {
    console.log('Message Recieved: ' + message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
http.listen(3000, function(){
    console.log('Listening on Port 3000');
});