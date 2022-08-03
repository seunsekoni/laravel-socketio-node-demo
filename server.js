'use strict';
const { strict } = require('assert');
const express = require('express')
const app = express()
const http = require('http');
const server = http.createServer(app);
const io = require('socket.io')(server, {
    cors: {
        origin: '*',
    }
});
require('dotenv').config();
const redisPort = process.env.REDIS_PORT;
const redisHost = process.env.REDIS_HOST;
const ioRedis = require('ioredis');
const redis = new ioRedis(redisPort, redisHost);

// using redis
redis.subscribe('chat-message');
redis.on('message', function (channel, message) {
    message  = JSON.parse(message);
    console.log(channel, message);
    // io.emit(channel + ':' + message.event, message.data);
    io.emit('chat-message', message);
});


// Establishing a connection
// io.on('connection', (socket) => {
//     console.log('a user connected');
//     socket.on('chat-message', (message) => {
//         // Send message to all connected clients
//         io.emit('chat-message', message);
//     })
//     socket.on('disconnect', () => {
//         console.log('user disconnected');
//     }
//     );
// });

server.listen(3000, () => {
    console.log('Server listening on port 3000');
});