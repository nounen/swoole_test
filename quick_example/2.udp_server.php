<?php

//创建Server对象，监听 127.0.0.1:9502端口，类型为SWOOLE_SOCK_UDP
$serv = new swoole_server("127.0.0.1", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

//监听数据接收事件
$serv->on('Packet', function ($serv, $data, $clientInfo) {
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server 原样返回数据 -- {$data}");

    var_dump('客户端信息：');
    var_dump($clientInfo);
});

//启动服务器
$serv->start();


/*
### UDP服务器 和 TCP服务器 的区别
* UDP 服务器 与 TCP 服务器不同， **UDP 没有连接的概念**。启动 Server 后，客户端无需 Connect，直接可以向 Server 监听的 9502 端口发送数据包。对应的事件为 onPacket。

* $clientInfo是客户端的相关信息，是一个数组，有客户端的IP和端口等内容
* 调用 $server->sendto 方法向客户端发送数据


### 执行程序
* 启动服务： `php udp_server.php`

* UDP 服务器可以使用 `netcat -u` 来连接测试
```shell
netcat -u 127.0.0.1 9502
hello
Server: hello
```

### 服务器退出客户端也不知道， 表现为客户端收不到数据 （但并不一定能作为 udp 服务器断开的标识）
*/