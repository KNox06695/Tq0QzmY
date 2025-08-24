<?php
// 代码生成时间: 2025-08-24 09:08:16
// XSS Protection class
// Provides basic XSS protection by escaping output
class XssProtection {
    
    /**
     * Escapes output to prevent XSS attacks.
     *
     * @param string $content The content to be escaped.
     * @return string Escaped content.
     */
    public static function escapeOutput($content) {
        // Use htmlspecialchars to convert special characters to HTML entities
        return htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitizes input to prevent XSS attacks.
     *
     * @param string $input The input to be sanitized.
     * @param bool $stripTags Whether to strip HTML tags or not.
     * @return string Sanitized input.
     */
    public static function sanitizeInput($input, $stripTags = true) {
        // If stripping tags, remove all HTML tags from the input
        if ($stripTags) {
            $input = strip_tags($input);
        }
        // Escape the input to convert special characters to HTML entities
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}

// Usage example
try {
    // Assume $userInput is the input received from the user
    $userInput = "<script>alert('XSS')</script>";

    // Sanitize the input to prevent XSS attacks
    $sanitizedInput = XssProtection::sanitizeInput($userInput, true);

    // Escape the output to prevent XSS attacks
    $escapedOutput = XssProtection::escapeOutput($sanitizedInput);

    // Display the escaped output safely
    echo $escapedOutput;
} catch (Exception $e) {
    // Handle any errors that occur
    error_log($e->getMessage());
    echo "An error occurred while processing your request.";
}
