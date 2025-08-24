<?php
// 代码生成时间: 2025-08-24 22:21:57
require 'vendor/autoload.php';
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\InvalidPropertyException;

class DatabaseBackupRestore {

    private $dbConfig = [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'root',
        'password' => '',
        'database' => 'your_database',
    ];

    /**
     * 备份数据库
     *
     * @param string $backupPath 备份文件保存路径
     * @return bool
     */
    public function backupDatabase($backupPath) {
        try {
            $dsn = 'mysql:host=' . $this->dbConfig['host'] . ';port=' . $this->dbConfig['port'] . ';dbname=' . $this->dbConfig['database'];
            $pdo = new PDO($dsn, $this->dbConfig['username'], $this->dbConfig['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM information_schema.SCHEMA_PRIVILEGES WHERE TABLE_SCHEMA = ?';
            $statement = $pdo->prepare($sql);
            $statement->execute([$this->dbConfig['database']]);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $privileges = [];
            foreach ($results as $row) {
                $privileges[$row['TABLE_NAME']] = $row['PRIVILEGE_TYPE'];
            }
            $dump = "-- MySQL dump 
-- Host: \{$this->dbConfig['host']}
-- Version: 8.0.26 
-- Date: '2023-07-07 17:00:00' 
-- 
-- Database: `$this->dbConfig['database']`

";
            foreach ($privileges as $table => $priv) {
                $dump .= "-- Table structure for table `$table`
";
                $dump .= $this->getTableStructure($table, $pdo) . ";

";
                $dump .= "-- Dumping data for table `$table`
";
                $dump .= $this->getTableData($table, $pdo) . ";

";
            }
            file_put_contents($backupPath, $dump);
            return true;
        } catch (PDOException $e) {
            // 错误处理
            return false;
        }
    }

    /**
     * 获取表结构
     *
     * @param string $tableName 表名
     * @param PDO $pdo PDO连接对象
     * @return string
     */
    private function getTableStructure($tableName, $pdo) {
        $sql = "SHOW CREATE TABLE `$tableName`";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['Create Table'];
    }

    /**
     * 获取表数据
     *
     * @param string $tableName 表名
     * @param PDO $pdo PDO连接对象
     * @return string
     */
    private function getTableData($tableName, $pdo) {
        $sql = "SELECT * FROM `$tableName`";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $data = [];
        foreach ($results as $row) {
            $data[] = '(' . implode(',', array_map(function ($value) {
                if (is_null($value)) {
                    return 'NULL';
                } elseif (is_string($value)) {
                    return "'" . addslashes($value) . "'";
                } else {
                    return $value;
                }
            }, $row)) . ')';
        }
        return "INSERT INTO `$tableName` VALUES " . implode(',', $data) . ";";
    }

    /**
     * 恢复数据库
     *
     * @param string $backupPath 备份文件路径
     * @return bool
     */
    public function restoreDatabase($backupPath) {
        try {
            $dsn = 'mysql:host=' . $this->dbConfig['host'] . ';port=' . $this->dbConfig['port'] . ';dbname=' . $this->dbConfig['database'];
            $pdo = new PDO($dsn, $this->dbConfig['username'], $this->dbConfig['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dump = file_get_contents($backupPath);
            $pdo->exec($dump);
            return true;
        } catch (PDOException $e) {
            // 错误处理
            return false;
        }
    }
}

// 示例用法
$backupRestore = new DatabaseBackupRestore();
$backupPath = 'backup.sql';
if ($backupRestore->backupDatabase($backupPath)) {
    echo '数据库备份成功';
} else {
    echo '数据库备份失败';
}

if ($backupRestore->restoreDatabase($backupPath)) {
    echo '数据库恢复成功';
} else {
    echo '数据库恢复失败';
}
