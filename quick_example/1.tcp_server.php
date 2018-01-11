<?php
/**
 * 1.创建TCP服务器
 */

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);

// 监听连接进入事件
$serv->on('connect', function ($serv, $fd) {
   echo "Client: connect.\n";
});

// 监听数据接收事件
$serv->on('receive', function ($serv, $fd, $fromId, $data) {
    $serv->send($fd, "Server:" . $data);
});

// 监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
   echo "Client: Close.\n";
});

// 启动服务器
$serv->start();

/*

## 创建TCP服务器
* 这里就创建了一个 TCP 服务器，监听本机 9501 端口。它的逻辑很简单，当客户端 Socket 通过网络发送一个 hello 字符串时，服务器会回复一个 Server: hello 字符串。

* swoole_server **是异步服务器，所以是通过监听事件的方式来编写程序的**
    * 当对应的 **事件** 发生时底层会主动回调指定的 PHP 函数。

    * 如当有新的 TCP 连接进入时会执行 onConnect 事件回调，当某个连接向服务器发送数据时会回调 onReceive 函数。

* 服务器可以同时被成千上万个客户端连接，$fd 就是客户端连接的唯一标识符
* 调用 $server->send() 方法向客户端连接发送数据，参数就是 $fd 客户端标识符
* 调用 $server->close() 方法可以强制关闭某个客户端连接
* 客户端可能会主动断开连接，此时会触发 onClose 事件回调


## 执行程序
* 服务端: `php server.php`

* 在命令行下运行 server.php 程序，启动成功后可以使用 netstat 工具看到，已经在监听 9501 端口。这时就可以使用 telnet/netcat 工具连接服务器。

* telent 操作:
```sh
telnet 127.0.0.1 9501
hello
Server: hello
```

* 如何退出telnet: https://www.jianshu.com/p/cb846c926edc


*/