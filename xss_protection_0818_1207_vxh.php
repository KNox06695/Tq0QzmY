<?php
// 代码生成时间: 2025-08-18 12:07:06
class XssProtection {

    /**
     * Sanitize input data to prevent XSS attacks.
     *
     * @param string $input The input data to sanitize.
     * @return string Sanitize input data.
     */
    public function sanitizeInput($input) {
        // Use CakePHP's Security Component to sanitize input data.
        // This is a simplified example. For more complex scenarios,
        // consider using a library like HTMLPurifier or a similar solution.
        
        App::uses('Security', 'Utility');
        $sanitizedInput = Security::stripTags($input);
        
        return $sanitizedInput;
    }

    /**
     * Sanitize output data to prevent XSS attacks.
     *
     * @param string $output The output data to sanitize.
     * @return string Sanitize output data.
     */
    public function sanitizeOutput($output) {
        // Use CakePHP's Security Component to sanitize output data.
        $sanitizedOutput = h($output);
        
        return $sanitizedOutput;
    }
}

// Usage example:

// Instantiate the XssProtection class.
$xssProtection = new XssProtection();

// Sanitize user input.
$userInput = "<script>alert('XSS')</script>";
$sanitizedInput = $xssProtection->sanitizeInput($userInput);

// Sanitize user output.
$userOutput = "<script>alert('XSS')</script>";
$sanitizedOutput = $xssProtection->sanitizeOutput($userOutput);

// Output the sanitized input and output.
echo "Sanitized Input: " . $sanitizedInput;
echo "Sanitized Output: " . $sanitizedOutput;
