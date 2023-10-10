<?php
require_once('config.php');

function handleErrors($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}

function handleExceptions($exception) {
    $logFile = fopen("error_log.txt", "a");
    fwrite($logFile, "[" . date("Y-m-d H:i:s") . "] Exception: " . $exception->getMessage() . "\n");
    fclose($logFile);
    http_response_code(500);
    echo json_encode(['status' => 'failure', 'message' => 'Internal Server Error']);
}

set_error_handler("handleErrors");
set_exception_handler("handleExceptions");
?>
