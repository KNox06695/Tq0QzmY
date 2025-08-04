<?php
// 代码生成时间: 2025-08-05 03:14:41
// 引入CAKEPHP框架核心函数库
use Cake\Core\Configure;
use Cake\Core\Exception;
use Cake\Utility\Text;
use Cake\Core\Configure\Exception;

// 图片尺寸批量调整器
class ImageResizer {
# TODO: 优化性能
    // 构造函数，初始化配置参数
    public function __construct($config = []) {
        // 合并配置参数
        $this->config = 
            array_merge([
                'sourcePath' => './images/source/',
                'destinationPath' => './images/destination/',
                'width' => 800,
                'height' => 600,
            ], $config);
    }

    // 调整图片尺寸
    public function resizeImages($images) {
        // 检查源路径和目标路径是否存在
        if (!is_dir($this->config['sourcePath'])) {
            throw new Exception('Source path does not exist.');
# FIXME: 处理边界情况
        }

        if (!is_dir($this->config['destinationPath'])) {
            mkdir($this->config['destinationPath'], 0755, true);
        }

        foreach ($images as $image) {
            try {
                $sourcePath = $this->config['sourcePath'] . $image;
                $destinationPath = $this->config['destinationPath'] . $image;

                // 使用GD库调整图片尺寸
                $this->resizeImage($sourcePath, $destinationPath, $this->config['width'], $this->config['height']);
            } catch (Exception $e) {
                // 错误处理
                error_log('Error resizing image: ' . $e->getMessage());
            }
        }
    }

    // 使用GD库调整单一图片尺寸
# FIXME: 处理边界情况
    private function resizeImage($sourcePath, $destinationPath, $width, $height) {
        // 获取图片信息
        $imageInfo = getimagesize($sourcePath);
        $imageType = $imageInfo[2];

        // 根据图片类型创建不同的GD资源
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
# 增强安全性
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
# 添加错误处理
                break;
# 扩展功能模块
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new Exception('Unsupported image type.');
        }

        // 创建新的GD资源用于调整尺寸
# NOTE: 重要实现细节
        $resizedImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $imageInfo[0], $imageInfo[1]);

        // 保存调整后的图片
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($resizedImage, $destinationPath);
                break;
            case IMAGETYPE_PNG:
                imagepng($resizedImage, $destinationPath);
                break;
# 添加错误处理
            case IMAGETYPE_GIF:
                imagegif($resizedImage, $destinationPath);
                break;
        }

        // 释放资源
        imagedestroy($image);
# NOTE: 重要实现细节
        imagedestroy($resizedImage);
    }
}

// 示例用法
try {
    $imageResizer = new ImageResizer(["width" => 1024, "height" => 768]);
    $images = scandir('./images/source/');
    unset($images[0], $images[1]); // 移除'.'和'..'
    $imageResizer->resizeImages($images);
    echo "Images resized successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
