<?php
function write_log($message) {
    $file = __DIR__ . '/debug.log'; // Ruta al archivo de log
    $date = date('Y-m-d H:i:s');
    $formatted_message = "[{$date}] {$message}" . PHP_EOL;
    file_put_contents($file, $formatted_message, FILE_APPEND);
}
?>
