<?php

$http = new swoole_http_server("0.0.0.0", 9501);

$requestCount = 0;

$http->on('request', function ($request, $response) {
    // TODO: 浏览器会自动发起 favicon.ico 文件的请求, 在这里先频屏蔽掉
    $icons = [
        $request->server['path_info'],
        $request->server['request_uri'],
    ];

    if (in_array('/favicon.ico', $icons)) {
        return $response->end();
    }

    global $requestCount;

    $requestCount++;

    var_dump($request->get, $request->post);

    var_dump($response);

    var_dump("============== 第 {$requestCount} 次请求 ============");

    $response->header("Content-Type", "text/html; charset=utf-8");

    $response->end("<h1>第 {$requestCount} 次请求： Hello Swoole. #".rand(1000, 9999)."</h1>");
});

$http->start();


/*
### HTTP 服务器
* Http 服务器只需要关注请求响应即可，所以只需要监听一个 onRequest 事件。当有新的 Http 请求进入就会触发此事件。事件回调函数有 2 个参数，一个是 $request 对象，包含了请求的相关信息，如 GET/POST 请求的数据。

* 另外一个是 response 对象，对 request 的响应可以通过操作 response 对象来完成。$response->end() 方法表示输出一段 HTML 内容，并结束此请求。

* 0.0.0.0 表示监听所有 IP 地址，一台服务器可能同时有多个 IP，如 127.0.0.1 本地回环 IP、192.168.1.100 局域网 IP、210.127.20.2 外网 IP，这里也可以单独指定监听一个 IP

* 9501 监听的端口，如果被占用程序会抛出致命错误，中断执行。


### 执行程序
* php http_server.php

* 客户端
    * 可以打开浏览器，访问 http://127.0.0.1:9501 查看程序的结果
    * 也可以使用 apache ab 工具对服务器进行压力测试


### TODO
* 为什么不同的浏览器访问 $requestCount 是不同的两个变量？ 而同一个浏览器的不同 tab 刷新 $requestCount 是同一个变量（自增不中断）？
    * swoole 底层的原理是什么？

    * 案例中 var_dump($response); Swoole\Http\Response 的 fd（$from_id） 属性似乎是关键。

*/