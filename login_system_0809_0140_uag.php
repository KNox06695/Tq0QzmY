<?php
// 代码生成时间: 2025-08-09 01:40:16
// 引入CAKEPHP框架
require_once 'vendor/autoload.php';

use Cake\ORM\TableRegistry;
use Cake\Auth\Auth;
use Cake\Controller\Controller;
use Cake\Controller\Exception\UnauthorizedException;
use Cake\Controller\Exception\ForbiddenException;

class UsersController extends Controller
{
    // 用户登录验证方法
    public function login()
    {
        // 获取请求数据
        $request = $this->request;
        $username = $request->getData('username');
        $password = $request->getData('password');

        // 验证参数
        if (empty($request->getData())) {
            $this->set('error', 'Username and password are required');
            return;
        }

        // 使用CakePHP的Auth组件进行认证
        $user = $this->Auth->identify();
        if (!$user) {
            $this->set('error', 'Invalid username or password');
            return;
        }

        // 认证成功后，保存用户信息
        $this->Auth->setUser($user);

        // 重定向到首页
        return $this->redirect('/');
    }

    // 用户登出方法
    public function logout()
    {
        // 使用CakePHP的Auth组件进行登出
        $this->Auth->logout();

        // 重定向到登录页面
        return $this->redirect('/login');
    }
}
