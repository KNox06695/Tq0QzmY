<?php
// 代码生成时间: 2025-09-24 20:54:39
class FileSyncTool
{
    // Source directory path
    private $sourcePath;

    // Destination directory path
    private $destinationPath;

    /**
     * Constructor
     *
     * @param string $sourcePath The source directory path
     * @param string $destinationPath The destination directory path
     */
    public function __construct($sourcePath, $destinationPath)
    {
        $this->sourcePath = $sourcePath;
        $this->destinationPath = $destinationPath;
    }

    /**
     * Backup files
     *
     * This method backs up the files from the source directory to the destination directory.
     *
     * @return bool Returns true on success and false on failure
     */
    public function backupFiles()
    {
        // Check if source and destination directories exist
        if (!is_dir($this->sourcePath) || !is_dir($this->destinationPath)) {
            error_log('Source or destination directory does not exist.');
            return false;
        }

        // Recursively iterate through the source directory
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->sourcePath),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            // Skip directories
            if ($item->isDir()) {
                continue;
            }

            // Construct the destination file path
            $destinationFile = $this->destinationPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

            // Copy the file to the destination directory
            if (!@copy($item, $destinationFile)) {
                error_log('Failed to copy file: ' . $item->getPathname());
                return false;
            }
        }

        return true;
    }

    /**
     * Synchronize files
     *
     * This method synchronizes the files between the source and destination directories.
     * It deletes files in the destination that do not exist in the source.
     *
     * @return bool Returns true on success and false on failure
     */
    public function synchronizeFiles()
    {
        // Check if source and destination directories exist
        if (!is_dir($this->sourcePath) || !is_dir($this->destinationPath)) {
            error_log('Source or destination directory does not exist.');
            return false;
        }

        // Iterate through the source directory
        $sourceFiles = new DirectoryIterator($this->sourcePath);

        foreach ($sourceFiles as $sourceFile) {
            if ($sourceFile->isDot() || $sourceFile->isDir()) {
                continue;
            }

            // Construct the destination file path
            $destinationFile = $this->destinationPath . DIRECTORY_SEPARATOR . $sourceFile->getFilename();

            // Check if the file exists in the destination directory
            if (!file_exists($destinationFile)) {
                // Copy the file to the destination directory
                if (!@copy($sourceFile->getPathname(), $destinationFile)) {
                    error_log('Failed to copy file: ' . $sourceFile->getPathname());
                    return false;
                }
            }
        }

        // Iterate through the destination directory and delete files that do not exist in the source
        $destinationFiles = new DirectoryIterator($this->destinationPath);

        foreach ($destinationFiles as $destinationFile) {
            if ($destinationFile->isDot() || $destinationFile->isDir()) {
                continue;
            }

            // Construct the source file path
            $sourceFile = $this->sourcePath . DIRECTORY_SEPARATOR . $destinationFile->getFilename();

            // Check if the file exists in the source directory
            if (!file_exists($sourceFile)) {
                // Delete the file from the destination directory
                if (!@unlink($destinationFile->getPathname())) {
                    error_log('Failed to delete file: ' . $destinationFile->getPathname());
                    return false;
                }
            }
        }

        return true;
    }
}

// Usage example
try {
    $sourcePath = '/path/to/source/directory';
    $destinationPath = '/path/to/destination/directory';

    $fileSyncTool = new FileSyncTool($sourcePath, $destinationPath);

    // Backup files
    if ($fileSyncTool->backupFiles()) {
        echo 'Files backed up successfully.';
    } else {
        echo 'Failed to backup files.';
    }

    // Synchronize files
    if ($fileSyncTool->synchronizeFiles()) {
        echo 'Files synchronized successfully.';
    } else {
        echo 'Failed to synchronize files.';
    }
} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
}
