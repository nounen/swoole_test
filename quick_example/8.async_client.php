<?php

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

// 注册连接成功回调
$client->on("connect", function($cli) {
    $cli->send("hello world\n");
});

// 注册数据接收回调
$client->on("receive", function($cli, $data) {
    echo "Received: ".$data."\n";
});

// 注册连接失败回调
$client->on("error", function($cli) {
    echo "Connect failed\n";
});

// 注册连接关闭回调
$client->on("close", function($cli) {
    echo "Connection close\n";
});

// 发起连接
$client->connect('127.0.0.1', 9501, 0.5);

/*
### 创建异步 TCP 客户端
* 异步客户端与上一个同步 TCP 客户端不同，**异步客户端是非阻塞的**。可以用于编写高并发的程序。swoole 官方提供的 redis-async、mysql-async 都是基于异步 swoole_client 实现的。

* 异步客户端需要设置回调函数，有 4 个事件回调必须设置 onConnect、 onError、 onReceive、 onClose。分别在客户端连接成功、连接失败、收到数据、连接关闭时触发。

* $client->connect() 发起连接的操作会立即返回，不存在任何等待。当对应的 IO 事件完成后，swoole 底层会自动调用设置好的回调函数。


### 注意: 异步客户端只能用于 cli 环境


### 运行程序
* 服务端: php tcp_server.php
* 客户端: php async_client.php
*/