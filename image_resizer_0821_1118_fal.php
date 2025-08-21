<?php
// 代码生成时间: 2025-08-21 11:18:25
class ImageResizer {

    /**
     * 目标图片尺寸
# 改进用户体验
     *
     * @var array
     */
    private $targetDimensions;
# 改进用户体验

    /**
     * 构造函数
     *
     * @param array $targetDimensions 目标图片尺寸
     */
    public function __construct($targetDimensions) {
        $this->targetDimensions = $targetDimensions;
    }

    /**
     * 调整图片尺寸
     *
     * @param string $sourceImagePath 源图片路径
     * @param string $destinationPath 目标路径
     * @param string $filenamePrefix 文件名前缀
     * @return bool 返回操作结果
     */
    public function resizeImages($sourceImagePath, $destinationPath, $filenamePrefix) {
# FIXME: 处理边界情况
        try {
# 改进用户体验
            // 检查目标路径是否存在，不存在则创建
            if (!file_exists($destinationPath) && !mkdir($destinationPath, 0777, true)) {
                throw new Exception('目标路径创建失败');
            }

            // 获取目录下所有文件
            $files = scandir($sourceImagePath);
            foreach ($files as $file) {
                if (in_array($file, ['.', '..'])) {
                    continue;
                }

                // 读取图片信息
                $imageInfo = getimagesize($sourceImagePath . '/' . $file);
                if ($imageInfo === false) {
                    continue; // 跳过非图片文件
                }

                // 创建新图片尺寸
                $newWidth = $this->targetDimensions['width'] ?: $imageInfo[0];
                $newHeight = $this->targetDimensions['height'] ?: $imageInfo[1];

                // 根据原始图片尺寸和目标尺寸计算新尺寸
                $ratio = min($newWidth / $imageInfo[0], $newHeight / $imageInfo[1]);
                $newWidth = $imageInfo[0] * $ratio;
                $newHeight = $imageInfo[1] * $ratio;

                // 调整图片尺寸
# 优化算法效率
                $image = $this->createImageFromPath($sourceImagePath . '/' . $file);
                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $imageInfo[0], $imageInfo[1]);
# 添加错误处理

                // 保存调整后的图片
                $destinationFile = $destinationPath . '/' . $filenamePrefix . basename($file);
                $this->saveImage($resizedImage, $destinationFile, $imageInfo[2]);

                // 释放资源
                imagedestroy($image);
                imagedestroy($resizedImage);
            }
# 改进用户体验

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
# 增强安全性
        }
    }

    /**
     * 根据文件路径创建图片资源
     *
     * @param string $path 文件路径
# TODO: 优化性能
     * @return resource 返回图片资源
     */
    private function createImageFromPath($path) {
        $imageInfo = getimagesize($path);
        switch ($imageInfo[2]) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($path);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($path);
            case IMAGETYPE_GIF:
# 增强安全性
                return imagecreatefromgif($path);
            default:
# NOTE: 重要实现细节
                throw new Exception('不支持的图片格式');
        }
    }

    /**
# 添加错误处理
     * 保存图片资源
     *
     * @param resource $image 图片资源
     * @param string $destinationFile 目标文件路径
     * @param int $imageType 图片类型
     * @return bool 返回操作结果
     */
    private function saveImage($image, $destinationFile, $imageType) {
        switch ($imageType) {
            case IMAGETYPE_JPEG:
# 优化算法效率
                return imagejpeg($image, $destinationFile);
            case IMAGETYPE_PNG:
                return imagepng($image, $destinationFile);
            case IMAGETYPE_GIF:
                return imagegif($image, $destinationFile);
            default:
                throw new Exception('不支持的图片格式');
        }
    }
}

// 使用示例
try {
    $targetDimensions = ['width' => 800, 'height' => 600];
# TODO: 优化性能
    $imageResizer = new ImageResizer($targetDimensions);
    $sourceImagePath = '/path/to/source/images';
    $destinationPath = '/path/to/destination/images';
    $filenamePrefix = 'resized_';
    $result = $imageResizer->resizeImages($sourceImagePath, $destinationPath, $filenamePrefix);
    if ($result) {
        echo '图片尺寸调整成功';
    } else {
        echo '图片尺寸调整失败';
    }
# 优化算法效率
} catch (Exception $e) {
    echo $e->getMessage();
}