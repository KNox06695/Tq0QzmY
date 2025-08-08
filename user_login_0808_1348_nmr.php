<?php
// 代码生成时间: 2025-08-08 13:48:24
// 用户登录验证系统

// 引入 CakePHP 的自动加载功能
require 'vendor/autoload.php';

use Cake\ORM\TableRegistry;
use Cake\Database\Exception\ConnectionException;
use Cake\Auth\Auth;
use Cake\Auth\FormAuthenticate;
use Cake\Controller\Controller;
use Cake\Routing\Router;

class UsersController extends Controller
{
    // 构造函数
    public function __construct($event = null)
    {
        parent::__construct($event);
        // 启用 CakePHP 的身份验证组件
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ],
                ],
            ],
        ]);
    }

    // 登录页面
    public function login()
    {
        if ($this->request->is('post')) {
            try {
                // 尝试通过表单验证用户信息
                $user = $this->Auth->identify();
                if ($user) {
                    // 如果验证成功，将用户信息保存到会话
                    $this->Auth->setUser($user);
                    // 重定向到登录前的页面
                    return $this->redirect($this->Auth->redirectUrl());
                }
            } catch (ConnectionException $exception) {
                // 处理数据库连接异常
                $this->Flash->error(__('Database connection error'));
            } catch (\Exception $exception) {
                // 处理其他异常
                $this->Flash->error(__('Invalid username or password'));
            }
        }
        // 如果请求不是 POST 类型，显示登录表单
    }

    // 登出页面
    public function logout()
    {
        // 清除用户会话信息并重定向到登录页面
        $this->Auth->logout();
        return $this->redirect($this->Auth->loginAction);
    }
}
