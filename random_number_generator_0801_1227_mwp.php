<?php
// 代码生成时间: 2025-08-01 12:27:01
// RandomNumberGenerator.php
// This class provides functionality to generate random numbers.

class RandomNumberGenerator {

    private $min; // Minimum value of the random number range
    private $max; // Maximum value of the random number range

    // Constructor to set the minimum and maximum values
    public function __construct($min, $max) {
        if ($min > $max) {
            throw new InvalidArgumentException('Minimum value cannot be greater than the maximum value.');
        }
        $this->min = $min;
        $this->max = $max;
    }

    // Method to generate a random number within the specified range
    public function generateRandomNumber() {
        return rand($this->min, $this->max);
    }

    // Setter method for the minimum value
    public function setMin($min) {
        if ($min > $this->max) {
            throw new InvalidArgumentException('Minimum value cannot be greater than the maximum value.');
        }
        $this->min = $min;
    }

    // Setter method for the maximum value
    public function setMax($max) {
        if ($this->min > $max) {
            throw new InvalidArgumentException('Minimum value cannot be greater than the maximum value.');
        }
        $this->max = $max;
    }

    // Getter method for the minimum value
    public function getMin() {
        return $this->min;
    }

    // Getter method for the maximum value
    public function getMax() {
        return $this->max;
    }

}
