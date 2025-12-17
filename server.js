const express = require('express');
const http = require('http');
const socketio = require('socket.io');
const app = express();
const server = http.createServer(app);
const io = socketio(server);

let online = 0;
io.on('connection', socket => {
  online++;
  io.emit('online_count', online);
  socket.on('disconnect', () => {
    online--;
    io.emit('online_count', online);
  });
});

const PORT = process.env.PORT || 3001;
server.listen(PORT, ()=> console.log('Socket server listening on', PORT));
