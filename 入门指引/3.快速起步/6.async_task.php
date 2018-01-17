<?php

$serv = new swoole_server("127.0.0.1", 9501);

// 设置异步任务的工作进程数量
$serv->set([
    'task_worker_num' => 4
]);

// 监听连接进入事件
$serv->on('receive', function($serv, $fd, $from_id, $data) {
    echo "Client: connect.\n";

    // 投递异步任务 TODO: 这里参数传到 task
    $task_id = $serv->task("传到任务的数据");

    echo "Dispath AsyncTask: id=$task_id\n";
});

// 处理异步任务
$serv->on('task', function ($serv, $task_id, $from_id, $data) {
    sleep(3); // 假设我在处理什么

    echo "New AsyncTask[id=$task_id]".PHP_EOL;

    // 返回任务执行的结果 TODO: 这里参数传到 finish
    $serv->finish("receive 传来的数据: $data -> OK");
});

// 处理异步任务的结果
$serv->on('finish', function ($serv, $task_id, $data) {
    echo "AsyncTask[$task_id] Finish: task 传来的数据: $data".PHP_EOL;

    echo "=======================".PHP_EOL;
});

$serv->start();


/*
### 异步任务


### 使用场景
* 在 Server 程序中如果需要执行很耗时的操作，比如一个聊天服务器发送广播，Web 服务器中发送邮件。如果直接去执行这些函数就会阻塞当前进程，导致服务器响应变慢。

* Swoole 提供了异步任务处理的功能，可以投递一个异步任务到 TaskWorker 进程池中执行，不影响当前请求的处理速度。


### 代码解读
* 基于第一个 TCP 服务器，只需要增加 onTask 和 onFinish 2个事件回调函数即可。另外需要设置 task 进程数量，可以根据任务的耗时和任务量配置适量的 task 进程。

* 调用 $serv->task() 后，程序立即返回，继续向下执行代码。onTask 回调函数 Task 进程池内被异步执行。执行完成后调用 $serv->finish() 返回结果。

* finish操作是可选的，也可以不返回任何结果


### 运行
* php async_task.php

* 客户端: 通过浏览器访问

*/