### 学习Swoole需要掌握哪些基础知识
* https://wiki.swoole.com/wiki/page/487.html

### 编译
* 版本选择 https://github.com/swoole/swoole-src/releases
```sh
cd swoole
phpize
./configure
make
sudo make install

// 使用扩展
echo 'extension=swoole.so' >> /etc/php/7.0/mods-available/swoole.ini
cd /etc/php/7.0/cli/conf.d/ && sudo ln -s /etc/php/7.0/mods-available/swoole.ini 20-swoole.ini
cd /etc/php/7.0/fpm/conf.d/ && sudo ln -s /etc/php/7.0/mods-available/swoole.ini 20-swoole.ini
```

* 编译参数: https://wiki.swoole.com/wiki/page/437.html

### BashOnWindows
* BashOnWindows 环境下必须关闭 daemonize 选项 (TODO: 表示没找到)

* 需要修改 config.h 关闭(注释掉, 不是改为0) HAVE_SIGNALFD (./configure 后生成 config.h)


### PECL 安装
* `pecl install swoole`


### 传输层TCP和UDP的区别分析与应用场景
* http://blog.csdn.net/u013777351/article/details/49226101


### 快速起步 (示例代码在 quick_example)
* https://wiki.swoole.com/wiki/page/p-quickstart.html