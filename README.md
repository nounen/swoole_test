### 编译
* 版本选择 https://github.com/swoole/swoole-src/releases
```sh
cd swoole
phpize
./configure
make
sudo make install
```

### BashOnWindows
* BashOnWindows 环境下必须关闭 daemonize 选项 (TODO: 表示没找到)

* 需要修改 config.h 关闭(注释掉, 不是改为0) HAVE_SIGNALFD (./configure 后生成 config.h)
