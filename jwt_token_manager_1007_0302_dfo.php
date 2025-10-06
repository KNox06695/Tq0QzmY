<?php
// 代码生成时间: 2025-10-07 03:02:22
// jwt_token_manager.php
// 程序用于JWT令牌管理，包括生成和验证JWT令牌

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Cake\Core\Exception\Exception;

class JwtTokenManager {
    // 配置令牌的密钥
    protected $key;
    // 配置令牌的过期时间
    protected $expiry;

    public function __construct($key, $expiry = 3600) {
        $this->key = $key;
        $this->expiry = $expiry;
    }

    // 生成JWT令牌
    public function generateToken($data) {
        try {
            $token = array(
                "iss" => "Your_ISS",
                "aud" => "Your_AUD",
                "iat" => time(),
                "nbf" => time(),
                "exp" => time() + ($this->expiry),
                "data" => $data
            );

            // 使用密钥和算法生成JWT令牌
            return JWT::encode($token, $this->key);
        } catch (Exception $e) {
            // 错误处理
            return null;
        }
    }

    // 验证JWT令牌
    public function verifyToken($jwt) {
        try {
            // 解码并验证JWT令牌
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
            return $decoded;
        } catch (ExpiredException $e) {
            // 令牌过期错误处理
            return null;
        } catch (SignatureInvalidException $e) {
            // 签名无效错误处理
            return null;
        } catch (Exception $e) {
            // 其他错误处理
            return null;
        }
    }
}

// 使用示例
// $manager = new JwtTokenManager('your-secret-key');
// $token = $manager->generateToken(array('username' => 'user'));
// $decoded = $manager->verifyToken($token);
