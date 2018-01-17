<?php

$client = new swoole_client(SWOOLE_SOCK_TCP);

// 连接到服务器 (1.tcp_server.php)
if (! $client->connect('127.0.0.1', 9501, 0.5)) {
    die("connect failed.");
}

// 向服务器发送数据
if (! $client->send("hello world")) {
    die("send failed.");
}

// 从服务器接收数据
$data = $client->recv();

if (! $data) {
    die("recv failed.");
}

echo $data;

//关闭连接
$client->close();


/*
### 创建同步 TCP 客户端


### 执行过程
* 创建一个 TCP 的同步客户端，此客户端可以用于连接到我们第一个示例的 TCP 服务器。向服务器端发送一个 hello world 字符串，服务器会返回一个 Server: hello world 字符串。

* 这个 **客户端是同步阻塞的** ，connect/send/recv 会等待 IO 完成后再返回。同步阻塞操作并不消耗 CPU 资源，IO 操作未完成当前进程会自动转入 sleep 模式，当 IO 完成后操作系统会唤醒当前进程，继续向下执行代码。

* TCP 需要进行3次握手，所以 connect 至少需要3次网络传输过程
    * TODO: 三次握手怎么能看得到?

* 在发送少量数据时 $client->send 都是可以立即返回的。发送大量数据时，socket 缓存区可能会塞满，send 操作会阻塞。

* recv 操作会阻塞等待服务器返回数据，recv 耗时等于服务器处理时间 + 网络传输耗时之合。


### TCP通信过程
* https://www.swoole.com/static/image/tcp_syn.png


### 运行程序
* 服务端: php tcp_server.php
* 客户端: php sync_client.php

*/
