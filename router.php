<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

if (str_starts_with($path, '/api/')) {
    require __DIR__ . '/src/api.php';
    return true;
}

$file = __DIR__ . '/public' . ($path === '/' ? '/index.html' : $path);
$real = realpath($file);
$public = realpath(__DIR__ . '/public');

if ($real && str_starts_with($real, $public) && is_file($real)) {
    return false;
}

http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo 'not found';
return true;
