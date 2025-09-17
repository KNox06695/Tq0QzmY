<?php
// 代码生成时间: 2025-09-17 15:21:35
use Cake\ORM\TableRegistry;
use Faker\Generator as FakerGenerator;
use Cake\Database\Type;

// DataGenerator 类用于生成测试数据
class DataGenerator {
    private $faker;
    private $tables;

    // 构造函数
    public function __construct() {
        // 初始化 Faker 生成器
        $this->faker = FakerGenerator::create();
        // 获取 CakePHP 所有数据表实例
        $this->tables = TableRegistry::getTableLocator()->all();
    }

    // 生成测试数据
    public function generateTestData($table, $records = 10) {
        // 检查表是否存在
        if (!$this->tables->exists($table)) {
            throw new InvalidArgumentException("Table "$table" does not exist.");
        }

        // 获取表对象
        $tableObj = TableRegistry::getTableLocator()->get($table);

        // 开始事务
        $tableObj->connection()->transactional(function () use ($tableObj, $records) {
            for ($i = 0; $i < $records; $i++) {
                $data = $this->generateRowData($tableObj);
                $tableObj->newEntity();
                $tableObj->patchEntity($tableObj->newEntity(), $data);
                $tableObj->save($tableObj->newEntity());
            }
        });
    }

    // 生成单行数据
    private function generateRowData($tableObj) {
        $data = [];
        $schema = $tableObj->getSchema();
        foreach ($schema->columns() as $column) {
            // 根据字段类型生成数据
            switch ($schema->getColumnType($column)) {
                case Type::TYPE_STRING:
                    $data[$column] = $this->faker->word;
                    break;
                case Type::TYPE_INTEGER:
                    $data[$column] = $this->faker->randomNumber;
                    break;
                case Type::TYPE_BOOLEAN:
                    $data[$column] = $this->faker->boolean;
                    break;
                case Type::TYPE_DATE:
                    $data[$column] = $this->faker->date;
                    break;
                case Type::TYPE_TIME:
                    $data[$column] = $this->faker->time;
                    break;
                case Type::TYPE_DATETIME:
                    $data[$column] = $this->faker->dateTime;
                    break;
                // 可以根据需要添加更多字段类型的处理
                default:
                    $data[$column] = $this->faker->word;
            }
        }
        return $data;
    }
}

// 使用示例
try {
    $dataGenerator = new DataGenerator();
    $dataGenerator->generateTestData('Users', 100); // 为 Users 表生成 100 条测试数据
} catch (Exception $e) {
    // 错误处理
    echo 'Error: ' . $e->getMessage();
}