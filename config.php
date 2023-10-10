<?php
date_default_timezone_set('UTC');

// Consider using an environment variable to store your API key
define('OPENAI_API_KEY', 'Bearer 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');

function generateUuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function sendEmail($to, $subject, $body, $headers) {
    return mail($to, $subject, $body, $headers);
}

$timestamp = date('Y-m-d H:i:s');
$emailAddresses = ['saundrawhisman@mail.com', 'md.mgmt.app@gmail.com'];

// You can include headers like this in your API requests
$headers = [
    'Authorization: ' . OPENAI_API_KEY,
    'Content-Type: application/json'
];

?>
