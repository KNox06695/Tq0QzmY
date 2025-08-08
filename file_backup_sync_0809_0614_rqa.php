<?php
// 代码生成时间: 2025-08-09 06:14:46
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Security;

class FileBackupSync {

    private $sourceDir;
    private $targetDir;
    private $logger;

    /**
     * 构造函数
     *
     * @param string $sourceDir 源目录路径
     * @param string $targetDir 目标目录路径
     */
    public function __construct($sourceDir, $targetDir) {
        $this->sourceDir = $sourceDir;
        $this->targetDir = $targetDir;
        $this->logger = new Cake\Log\Log();
    }

    /**
     * 执行备份和同步操作
     *
     * @return void
     */
    public function backupAndSync() {
        try {
            $sourceFolder = new Folder($this->sourceDir);
            $targetFolder = new Folder($this->targetDir);

            // 获取源目录和目标目录中的文件列表
            $sourceFiles = $sourceFolder->read();
            $targetFiles = $targetFolder->read();

            // 遍历源目录中的文件
            foreach ($sourceFiles[0] as $file) {
                $sourceFilePath = $this->sourceDir . '/' . $file;
                $targetFilePath = $this->targetDir . '/' . $file;

                // 如果目标目录中不存在对应文件，则复制文件
                if (!in_array($file, $targetFiles[0])) {
                    $sourceFile = new File($sourceFilePath);
                    $sourceFile->copy($targetFilePath);
                    $this->log('文件已复制: ' . $file);
                } else {
                    // 否则，比较文件大小和修改时间，如果不同则更新文件
                    $sourceFile = new File($sourceFilePath);
                    $targetFile = new File($targetFilePath);

                    if ($sourceFile->size() != $targetFile->size() || $sourceFile->lastChange() != $targetFile->lastChange()) {
                        $sourceFile->copy($targetFilePath);
                        $this->log('文件已更新: ' . $file);
                    }
                }
            }

            // 删除目标目录中多余的文件
            foreach ($targetFiles[0] as $file) {
                if (!in_array($file, $sourceFiles[0])) {
                    $targetFilePath = $this->targetDir . '/' . $file;
                    $targetFile = new File($targetFilePath);
                    $targetFile->delete();
                    $this->log('文件已删除: ' . $file);
                }
            }

            $this->log('备份和同步操作完成。');
        } catch (Exception $e) {
            $this->log('错误: ' . $e->getMessage());
        }
    }

    /**
     * 记录日志
     *
     * @param string $message 日志信息
     * @return void
     */
    private function log($message) {
        $this->logger->write((string)$message, 'debug');
    }
}

// 示例用法
$sourceDir = '/path/to/source/directory';
$targetDir = '/path/to/target/directory';
$fileBackupSync = new FileBackupSync($sourceDir, $targetDir);
$fileBackupSync->backupAndSync();
}