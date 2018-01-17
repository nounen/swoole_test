<?php

$db = new Swoole\Mysql;

$server = array(
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => '',
    'database' => 'mysql',
);

$db->connect($server, function ($db, $result) {
    $db->query("show tables", function (Swoole\MySQL $db, $result) {
        var_dump($result);

        $db->close();
    });
});


/*
### 使用异步客户端
* PHP提供的 MySQL、CURL、Redis 等客户端是同步的，会导致服务器程序发生阻塞。Swoole 提供了常用的异步客户端组件，来解决此问题。编写纯异步服务器程序时，可以使用这些异步客户端。

* 异步客户端可以配合使用 SplQueue 实现连接池，以达到长连接复用的目的。在实际项目中可以使用 PHP 提供的 Yield / Generator 语法实现半协程的异步框架。也可以基于 Promises 简化异步程序的编写。


### 异步 Mysql
* 与 mysqli 和 PDO 等客户端不同，Swoole \ MySQL 是异步非阻塞的，连接服务器、执行 SQL 时，需要传入一个回调函数。connect 的结果不在返回值中，而是在回调函数中。query 的结果也需要在回调函数中进行处理。


*/