<?php
// 代码生成时间: 2025-10-10 16:56:01
class FileSplitMergeTool {

    /**
     * 分割文件
     *
     * @param string $sourceFilePath 大文件路径
     * @param string $destinationFolderPath 分割后小文件存放路径
     * @param int $chunkSize 分割后的每个文件大小（字节）
     *
     * @return bool 分割成功返回true，否则返回false
     */
    public function splitFile($sourceFilePath, $destinationFolderPath, $chunkSize) {
        if (!file_exists($sourceFilePath)) {
            throw new Exception("源文件不存在");
        }

        $sourceFile = fopen($sourceFilePath, 'r');
        if (!$sourceFile) {
            throw new Exception("无法打开源文件");
        }

        $totalSize = filesize($sourceFilePath);
        $chunkNumber = ceil($totalSize / $chunkSize);

        for ($i = 1; $i <= $chunkNumber; $i++) {
            $destinationFilePath = $destinationFolderPath . "/" . basename($sourceFilePath, '.txt') . "_chunk_" . $i . ".txt";
            $destinationFile = fopen($destinationFilePath, 'w');
            if (!$destinationFile) {
                throw new Exception("无法创建分割文件");
            }

            fseek($sourceFile, ($i - 1) * $chunkSize);
            $chunk = fread($sourceFile, $chunkSize);
            fwrite($destinationFile, $chunk);
            fclose($destinationFile);
        }

        fclose($sourceFile);

        return true;
    }

    /**
     * 合并文件
     *
     * @param string $sourceFolderPath 包含小文件的文件夹路径
     * @param string $destinationFilePath 合并后的大文件路径
     *
     * @return bool 合并成功返回true，否则返回false
     */
    public function mergeFiles($sourceFolderPath, $destinationFilePath) {
        if (!is_dir($sourceFolderPath)) {
            throw new Exception("源文件夹不存在");
        }

        $files = scandir($sourceFolderPath);
        if (empty($files)) {
            throw new Exception("文件夹为空");
        }

        $destinationFile = fopen($destinationFilePath, 'w');
        if (!$destinationFile) {
            throw new Exception("无法创建合并文件");
        }

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $sourceFilePath = $sourceFolderPath . "/" . $file;
            $sourceFile = fopen($sourceFilePath, 'r');
            if (!$sourceFile) {
                throw new Exception("无法打开分割文件");
            }

            while (!feof($sourceFile)) {
                $content = fread($sourceFile, 1024);
                fwrite($destinationFile, $content);
            }

            fclose($sourceFile);
        }

        fclose($destinationFile);

        return true;
    }

}

// 测试代码
try {
    $tool = new FileSplitMergeTool();
    // 分割文件
    $tool->splitFile('path/to/largefile.txt', 'path/to/chunks', 1024 * 1024); // 分割成1MB的文件
    // 合并文件
    $tool->mergeFiles('path/to/chunks', 'path/to/mergedfile.txt');
    echo "文件分割合并成功";
} catch (Exception $e) {
    echo "发生错误: " . $e->getMessage();
}
