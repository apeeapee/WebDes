<?php
// Serve files from storage/app/public when symlink is not available
$file = $_GET['file'] ?? '';
$file = str_replace(['..', "\0"], '', $file); // Security

$path = __DIR__ . '/../storage/app/public/' . $file;

if (!file_exists($path) || is_dir($path)) {
    http_response_code(404);
    exit('File not found');
}

$mime = mime_content_type($path) ?: 'application/octet-stream';
header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
header('Cache-Control: public, max-age=31536000');
readfile($path);
