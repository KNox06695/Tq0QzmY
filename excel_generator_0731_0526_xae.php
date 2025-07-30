<?php
// 代码生成时间: 2025-07-31 05:26:19
// CakePHP框架需先进行composer安装和配置

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Utility\Text;

class ExcelGenerator {

    /**
     * 创建一个新的Excel表格
     *
     * @param array $data 数据数组
     * @return void
     */
    public function createExcel(array $data): void {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // 设置表格标题
            $sheet->setTitle('Generated Data');

            // 填充数据到表格
            foreach ($data as $rowIndex => $row) {
                foreach ($row as $colIndex => $cell) {
                    $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $cell);
                }
            }

            // 设置表格的列宽
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);

            // 保存Excel文件
            $writer = new Xlsx($spreadsheet);
            $filename = 'GeneratedData.xlsx';
            $writer->save($filename);

            echo "生成的Excel文件已保存为：{$filename}";
        } catch (Exception $e) {
            echo "生成Excel文件时出错：{$e->getMessage()}";
        }
    }

}

// 以下为测试代码
// 实例化ExcelGenerator类
$excelGen = new ExcelGenerator();

// 准备测试数据
$data = [
    ['Name', 'Age', 'Email'],
    ['John Doe', 30, 'john@example.com'],
    ['Jane Doe', 25, 'jane@example.com'],
];

// 生成Excel文件
$excelGen->createExcel($data);
