<?php
// 代码生成时间: 2025-08-28 06:51:22
use Cake\Utility\Hash;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Gd\Imagine;
use Imagine\Exception\RuntimeException;

// ImageResizer 类定义
class ImageResizer {

    private $sourcePath;
    private $targetPath;
    private $newWidth;
    private $newHeight;
    private $preserveAspect = true;
    private $image;

    // 构造函数
    public function __construct($sourcePath, $targetPath, $newWidth, $newHeight) {
        $this->sourcePath = $sourcePath;
        $this->targetPath = $targetPath;
        $this->newWidth = $newWidth;
        $this->newHeight = $newHeight;
        $this->image = new Imagine();
    }

    // 设置是否保持图片比例
    public function setPreserveAspect($preserveAspect) {
        $this->preserveAspect = $preserveAspect;
    }

    // 调整图片尺寸
    public function resizeImages() {
        $folder = new Folder($this->sourcePath);
        $images = $folder->findRecursive('.*\.(jpg|jpeg|png|gif)$');

        foreach ($images as $image) {
            $sourceFile = new File($this->sourcePath . '/' . $image);
            $targetFile = $this->targetPath . '/' . $image;

            try {
                $imageObj = $this->image->open($sourceFile->path);
                $size = $imageObj->getSize();

                if ($this->preserveAspect) {
                    $this->resizeMaintainingAspect($imageObj, $size);
                } else {
                    $this->resizeIgnoringAspect($imageObj);
                }

                $imageObj->save($targetFile);
            } catch (RuntimeException $e) {
                // 错误处理
                echo "Error resizing image {$image}: " . $e->getMessage() . "
";
            }
        }
    }

    // 保持图片比例调整尺寸
    private function resizeMaintainingAspect($imageObj, $size) {
        $ratio = $size->getWidth() / $size->getHeight();
        $newWidth = $this->newWidth;
        $newHeight = $this->newHeight;

        if ($ratio > 1) {
            $newHeight = $this->newWidth / $ratio;
        } else {
            $newWidth = $this->newHeight * $ratio;
        }

        $imageObj->resize(new Box($newWidth, $newHeight));
    }

    // 不保持图片比例调整尺寸
    private function resizeIgnoringAspect($imageObj) {
        $imageObj->resize(new Box($this->newWidth, $this->newHeight));
    }
}

// 使用示例
try {
    $resizer = new ImageResizer('/path/to/source', '/path/to/target', 800, 600);
    $resizer->setPreserveAspect(true);
    $resizer->resizeImages();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}
