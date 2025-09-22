<?php
// 代码生成时间: 2025-09-22 09:55:17
// Sorting Algorithm Implementation using PHP and CAKEPHP
// This class provides a basic sorting functionality

class SortingAlgorithm {

    /**
     * Sort an array using bubble sort algorithm
     *
     * @param array $array Array to be sorted
     * @return array Sorted array
     */
    public function bubbleSort($array) {
        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements if they are in wrong order
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;
    }

    /**
     * Sort an array using selection sort algorithm
     *
     * @param array $array Array to be sorted
     * @return array Sorted array
     */
    public function selectionSort($array) {
        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            // Find the minimum element in the remaining unsorted array
            $minIndex = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                if ($array[$j] < $array[$minIndex]) {
                    $minIndex = $j;
                }
            }
            // Swap the found minimum element with the first element
            $temp = $array[$minIndex];
            $array[$minIndex] = $array[$i];
            $array[$i] = $temp;
        }
        return $array;
    }

    /**
     * Sort an array using insertion sort algorithm
     *
     * @param array $array Array to be sorted
     * @return array Sorted array
     */
    public function insertionSort($array) {
        for ($i = 1; $i < count($array); $i++) {
            $key = $array[$i];
            $j = $i - 1;
            
            while ($j >= 0 && $array[$j] > $key) {
                $array[$j + 1] = $array[$j];
                $j = $j - 1;
            }
            $array[$j + 1] = $key;
        }
        return $array;
    }

    /**
     * Sort an array using quick sort algorithm
     *
     * @param array $array Array to be sorted
     * @return array Sorted array
     */
    public function quickSort($array) {
        if (count($array) < 2) {
            return $array;
        }
        $left = $right = array();
        $pivot = array_shift($array);
        foreach ($array as $item) {
            ($item < $pivot) ? $left[] = $item : $right[] = $item;
        }
        return array_merge($this->quickSort($left), array($pivot), $this->quickSort($right));
    }

    /**
     * Sort an array using merge sort algorithm
     *
     * @param array $array Array to be sorted
     * @return array Sorted array
     */
    public function mergeSort($array) {
        if (count($array) == 1) return $array;
        $mid = count($array) / 2;
        $left = array_slice($array, 0, $mid);
        $right = array_slice($array, $mid);
        $left = $this->mergeSort($left);
        $right = $this->mergeSort($right);
        return $this->merge($left, $right);
    }

    private function merge($left, $right) {
        $result = array();
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] < $right[0]) {
                array_push($result, array_shift($left));
            } else {
                array_push($result, array_shift($right));
            }
        }
        while (count($left) > 0) {
            array_push($result, array_shift($left));
        }
        while (count($right) > 0) {
            array_push($result, array_shift($right));
        }
        return $result;
    }

    /**
     * Sort an array using heap sort algorithm
     *
     * @param array $array Array to be sorted
     * @return array Sorted array
     */
    public function heapSort($array) {
        $n = count($array);
        // Build heap (rearrange array)
        for ($i = $n / 2 - 1; $i >= 0; $i--) {
            $this->heapify($array, $n, $i);
        }
        // One by one extract an element from heap
        for ($i = $n - 1; $i >= 0; $i--) {
            // Move current root to end
            $temp = $array[0];
            $array[0] = $array[$i];
            $array[$i] = $temp;
            // call max heapify on the reduced heap
            $this->heapify($array, $i, 0);
        }
        return $array;
    }

    private function heapify(&$array, $n, $i) {
        $largest = $i;
        $left = 2 * $i + 1;
        $right = 2 * $i + 2;
        if ($left < $n && $array[$left] > $array[$largest]) {
            $largest = $left;
        }
        if ($right < $n && $array[$right] > $array[$largest]) {
            $largest = $right;
        }
        if ($largest != $i) {
            $temp = $array[$i];
            $array[$i] = $array[$largest];
            $array[$largest] = $temp;
            // Recursively heapify the affected sub-tree
            $this->heapify($array, $n, $largest);
        }
    }

}
