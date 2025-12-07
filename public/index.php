<?php

// Requested URL path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Root path → load src/index.html
if ($path === '/' || $path === '/index.php') {
    echo file_get_contents(__DIR__ . '/../src/index.html');
    exit;
}

// If it ends with .html → load file from src/
if (str_ends_with($path, '.html')) {
    $file = __DIR__ . '/../src' . $path;

    if (file_exists($file)) {
        echo file_get_contents($file);
        exit;
    }
}

// For anything else → 404 or assets
http_response_code(404);
echo "404 Not Found";
