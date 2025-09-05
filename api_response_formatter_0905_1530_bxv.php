<?php
// 代码生成时间: 2025-09-05 15:30:42
class ApiResponseFormatter {

    /**
     * 格式化成功响应
     *
     * @param mixed $data 响应数据
     * @param string $message 响应消息
     * @return array 格式化后的响应数组
     */
# 优化算法效率
    public function success($data, $message = 'Operation successful') {
# 改进用户体验
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data
# TODO: 优化性能
        ];
    }

    /**
     * 格式化错误响应
     *
# 改进用户体验
     * @param string $message 错误消息
     * @param int $code 错误码
     * @param array $errors 错误详情
     * @return array 格式化后的错误响应数组
     */
# 添加错误处理
    public function error($message, $code = 400, $errors = []) {
        return [
            'status' => 'error',
            'message' => $message,
            'code' => $code,
            'errors' => $errors
        ];
    }

    /**
     * 格式化分页响应
     *
# TODO: 优化性能
     * @param array $data 数据数组
     * @param int $page 当前页码
     * @param int $perPage 每页数据条数
     * @param int $total 总数据条数
     * @return array 格式化后的分页响应数组
     */
# 改进用户体验
    public function paginate($data, $page, $perPage, $total) {
        return [
            'status' => 'success',
            'data' => $data,
# 优化算法效率
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'pages' => ceil($total / $perPage)
            ]
        ];
    }
}
# NOTE: 重要实现细节
