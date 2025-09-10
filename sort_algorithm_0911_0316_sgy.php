<?php
// 代码生成时间: 2025-09-11 03:16:49
class SortAlgorithm {

    /**
     * Bubble Sort Algorithm
     *
     * @param array $arr The array to be sorted
     * @return array The sorted array
     */
    public function bubbleSort(array $arr): array {
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    // Swap elements
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
        return $arr;
    }

    /**
     * Insertion Sort Algorithm
     *
     * @param array $arr The array to be sorted
     * @return array The sorted array
     */
    public function insertionSort(array $arr): array {
        for ($i = 1; $i < count($arr); $i++) {
            $key = $arr[$i];
            $j = $i - 1;

            while ($j >= 0 && $arr[$j] > $key) {
                $arr[$j + 1] = $arr[$j];
                $j--;
            }
            $arr[$j + 1] = $key;
        }
        return $arr;
    }

    /**
     * Test the sorting algorithms
     *
     * @param array $arr The array to be sorted
     */
    public function testSort(array $arr): void {
        try {
            $sortedArr = $this->bubbleSort($arr);
            echo "Bubble Sort Result: " . implode(', ', $sortedArr) . "
";

            $sortedArr = $this->insertionSort($arr);
            echo "Insertion Sort Result: " . implode(', ', $sortedArr) . "
";

        } catch (Exception $e) {
            // Error handling
            echo "Error: " . $e->getMessage();
        }
    }
}

// Example usage
$sorter = new SortAlgorithm();
$arrayToSort = [64, 34, 25, 12, 22, 11, 90];
$sorter->testSort($arrayToSort);
