<?php
require_once('config.php');

class Util {
    public static function generateUUID() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function getCurrentTimestamp() {
        return date("Y-m-d H:i:s");
    }

    public static function sanitizeString($str) {
        return filter_var($str, FILTER_SANITIZE_STRING);
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Other utility functions can be added here
}
?>
