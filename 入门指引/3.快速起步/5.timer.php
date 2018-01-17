<?php

// 每隔2000ms触发一次
swoole_timer_tick(2000, function ($timer_id) {
    echo "tick-2000ms\n";
});

// 3000ms后执行此函数
swoole_timer_after(3000, function () {
    echo "after 3000ms.\n";
});

/*
### 定时器
* swoole提供了类似JavaScript的setInterval/setTimeout异步高精度定时器，粒度为毫秒级。使用也非常简单。


* swoole_timer_tick 函数就相当于 setInterval，是 **持续触发** 的

* swoole_timer_after 函数相当于 setTimeout，仅在约定的时间触发一次

* swoole_timer_tick 和 swoole_timer_after 函数会返回一个整数，表示定时器ID
可以使用 swoole_timer_clear 清除此定时器，参数为定时器ID

*/