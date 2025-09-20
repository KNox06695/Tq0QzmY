<?php
// 代码生成时间: 2025-09-20 18:59:07
// network_connection_checker.php
// 网络连接状态检查器

// 引入 CakePHP 的自动加载功能
require_once 'vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Network\Exception\NetworkException;
use Cake\Network\ConnectionManager;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\ConsoleIo;
use Cake\Console\Shell;

class NetworkConnectionCheckerShell extends Shell
{
    public function check()
    {
        // 获取配置文件中定义的网络连接检查地址
        $urlToCheck = Configure::read('NetworkChecker.url');
        
        if (empty($urlToCheck)) {
            $this->err('网络连接检查的URL未配置，请在配置文件中设置NetworkChecker.url');
            return;
        }
        
        // 创建网络连接对象
        $connection = ConnectionManager::get('default');
        
        try {
            // 使用GET方法检查网络连接
            $connection->get($urlToCheck);
            $this->out('网络连接正常。');
        } catch (NetworkException $exception) {
            // 捕获网络异常情况
            $this->err('网络连接异常：' . $exception->getMessage());
        } catch (Exception $exception) {
            // 捕获其他异常情况
            $this->err('未知错误：' . $exception->getMessage());
        }
    }
}

// 如果这个脚本是独立运行的，执行网络连接检查
if ($_SERVER['argc'] == 1) {
    $shell = new NetworkConnectionCheckerShell(new ConsoleOptionParser(), new ConsoleIo());
    $shell->check();
}
