<?php
// 代码生成时间: 2025-09-19 08:18:13
class DataGenerator {

    private $data;
    private $faker;

    /**
     * 构造函数
     * 初始化Faker库
     */
    public function __construct() {
        // 初始化Faker库
        $this->faker = Faker\Factory::create();
        $this->data = [];
    }

    /**
     * 生成用户数据
     *
     * @param int $count 生成用户的数量
     * @return array 返回生成的用户数据数组
     */
    public function generateUsers($count) {
        $this->data = [];
        for ($i = 0; $i < $count; $i++) {
            $this->data[] = [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'address' => $this->faker->address,
                'phone' => $this->faker->phoneNumber,
            ];
        }
        return $this->data;
    }

    /**
     * 生成产品数据
     *
     * @param int $count 生成产品的数量
     * @return array 返回生成的产品数据数组
     */
    public function generateProducts($count) {
        $this->data = [];
        for ($i = 0; $i < $count; $i++) {
            $this->data[] = [
                'name' => $this->faker->word,
                'description' => $this->faker->text(200),
                'price' => $this->faker->randomFloat(2, 0, 1000),
                'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        }
        return $this->data;
    }

    /**
     * 获取生成的数据
     *
     * @return array 返回生成的数据数组
     */
    public function getData() {
        return $this->data;
    }
}

// 使用示例
try {
    $generator = new DataGenerator();
    $users = $generator->generateUsers(10);
    $products = $generator->generateProducts(20);
    print_r($users);
    print_r($products);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}