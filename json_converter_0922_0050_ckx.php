<?php
// 代码生成时间: 2025-09-22 00:50:39
class JsonConverter {

    /**
     * 将JSON字符串转换成数组
     *
     * @param string $json JSON字符串
     * @return array|false 转换后的数组或者在失败时返回false
     */
    public function jsonToArray($json) {
        // 检查是否为空
        if (empty($json)) {
            // 抛出异常
            throw new InvalidArgumentException('JSON字符串不能为空。');
        }

        // 尝试解码JSON字符串
        $data = json_decode($json, true);

        // 检查是否解码成功
        if (is_null($data)) {
            // 抛出异常
            throw new InvalidArgumentException('无效的JSON字符串。');
        }

        // 返回解码后的数组
        return $data;
    }

    /**
     * 将数组转换成JSON字符串
     *
     * @param array $array 数组
     * @return string 转换后的JSON字符串
     */
    public function arrayToJson(array $array) {
        // 尝试编码数组
        $json = json_encode($array);

        // 检查是否编码成功
        if (json_last_error() !== JSON_ERROR_NONE) {
            // 抛出异常
            throw new InvalidArgumentException('数组编码失败。');
        }

        // 返回编码后的JSON字符串
        return $json;
    }
}
