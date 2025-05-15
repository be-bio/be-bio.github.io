<?php
// Конфиг: сокращённый код => ссылка или локальный файл
$redirects = [
    "besctop" => "https://discord.gg/gtmcjxEGUq"

// Получаем код из URL
$code = $_GET['code'] ?? '';

if ($code && isset($redirects[$code])) {
    $target = $redirects[$code];

    // Если это локальный файл (например .exe), сделаем заголовок для скачивания/открытия
    if (preg_match('/\.exe$/i', $target)) {
        $filepath = __DIR__ . '/' . $target;
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            http_response_code(404);
            echo "Файл не найден.";
            exit;
        }
    } else {
        // Иначе редирект на URL
        header("Location: " . $target);
        exit;
    }
}

http_response_code(404);
echo "Код не найден.";
