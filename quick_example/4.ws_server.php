<?php

// 创建 websocket 服务器对象，监听 0.0.0.0:9502 端口
$ws = new swoole_websocket_server("0.0.0.0", 9502);

//监听 WebSocket 连接打开事件
$ws->on('open', function ($ws, $request) {
//    var_dump($request->fd, $request->get, $request->server);

    $ws->push($request->fd, "hello, welcome\n");
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    echo "Message: {$frame->data}\n";

    $ws->push($frame->fd, "server: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();


/*

### WebSocket服务器
* > WebSocket 服务器是建立在 Http 服务器之上的长连接服务器，客户端首先会发送一个 Http 的请求与服务器进行握手。握手成功后会触发 onOpen 事件，表示连接已就绪，onOpen 函数中可以得到 $request 对象，包含了 Http 握手的相关信息，如 GET参数、Cookie、Http 头信息等。

* 建立连接后客户端与服务器端就可以双向通信了。

* 客户端向服务器端发送信息时，服务器端触发 onMessage 事件回调

* 服务器端可以调用 $server->push() **向某个客户端（使用 $fd 标识符）发送消息**

* 服务器端可以设置 onHandShake 事件回调来手工处理 WebSocket 握手


### 执行程序
* `php ws_server.php`

* 客户端：
```js
var wsServer = 'ws://127.0.0.1:9502';
var websocket = new WebSocket(wsServer);
websocket.onopen = function (evt) {
    console.log("Connected to WebSocket server.");
};

websocket.onclose = function (evt) {
    console.log("Disconnected");
};

websocket.onmessage = function (evt) {
    console.log('Retrieved data from server: ' + evt.data);
};

websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data);
};
```

* 注意：
    * 不能直接使用 swoole_client 与 websocket 服务器通信，swoole_client 是 TCP 客户端
    * 必须实现 **WebSocket 协议** 才能和 WebSocket 服务器通信，可以使用 swoole/framework 提供的PHP WebSocket客户端


### Comet
* WebSocket 服务器除了提供 WebSocket 功能之外，实际上也可以处理 Http 长连接。只需要增加 onRequest 事件监听即可实现 Comet 方案 Http 长轮询。


*/