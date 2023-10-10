<?php
require_once('config.php');

function generateUuid() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

$uuid = generateUuid();
$timestamp = date('Y-m-d H:i:s');
$questionsAndAnswers = json_decode(file_get_contents('php://input'), true);
$emailAddresses = ["saundrawhisman@mail.com", "md.mgmt.app@gmail.com"];
$subject = "Interview Data: $uuid";
$headers = "From: exec.cloud.mgmt@gmail.com\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

$emailBody = "Interview conducted at: $timestamp\nUUID: $uuid\n\n";
foreach($questionsAndAnswers as $question => $answer) {
    $emailBody .= "$question: $answer\n";
}

function sendEmail($to, $subject, $body, $headers) {
    mail($to, $subject, $body, $headers);
}

foreach($emailAddresses as $email) {
    sendEmail($email, $subject, $emailBody, $headers);
}

echo json_encode(['status' => 'success']);
?>
