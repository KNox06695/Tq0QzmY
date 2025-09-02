<?php
// 代码生成时间: 2025-09-03 07:08:04
// CompressTool.php
// 压缩文件解压工具类

class CompressTool {
    // 解压文件的路径
    private $archivePath;
    // 解压后文件存放的路径
    private $destinationPath;

    // 构造函数
    public function __construct($archivePath, $destinationPath) {
        $this->archivePath = $archivePath;
        $this->destinationPath = $destinationPath;
    }

    // 解压文件
    public function extract() {
        if (!file_exists($this->archivePath)) {
            throw new Exception('Archive file does not exist.');
        }

        if (!is_writable($this->destinationPath)) {
            throw new Exception('Destination path is not writable.');
        }

        // 检测文件类型并解压
        $fileType = $this->detectFileType($this->archivePath);
        switch ($fileType) {
            case 'zip':
                $this->extractZip($this->archivePath, $this->destinationPath);
                break;
            case 'tar':
                $this->extractTar($this->archivePath, $this->destinationPath);
                break;
            default:
                throw new Exception('Unsupported archive type.');
        }
    }

    // 检测文件类型
    private function detectFileType($filePath) {
        $fileType = mime_content_type($filePath);
        if (strpos($fileType, 'zip') !== false) {
            return 'zip';
        } elseif (strpos($fileType, 'tar') !== false) {
            return 'tar';
        } else {
            return null;
        }
    }

    // 解压ZIP文件
    private function extractZip($zipPath, $destinationPath) {
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($zipPath) === true) {
                $zip->extractTo($destinationPath);
                $zip->close();
            } else {
                throw new Exception('Failed to open ZIP archive.');
            }
        } else {
            throw new Exception('ZipArchive class not found.');
        }
    }

    // 解压TAR文件
    private function extractTar($tarPath, $destinationPath) {
        if (function_exists('exec')) {
            $output = array();
            exec('tar -xvf ' . escapeshellarg($tarPath) . ' -C ' . escapeshellarg($destinationPath), $output);
            if ($output[0] !== 'tar: ' . basename($tarPath) . ': extracted') {
                throw new Exception('Failed to extract TAR archive.');
            }
        } else {
            throw new Exception('exec function is disabled.');
        }
    }
}
