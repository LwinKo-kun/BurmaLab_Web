<?php
/**
 * router.php – PHP built-in server front controller
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requested = __DIR__ . $uri;

// 1. Serve static assets (css, js, images) directly
if ($uri !== '/' && file_exists($requested) && !is_dir($requested)) {
    $ext = pathinfo($requested, PATHINFO_EXTENSION);
    $staticExts = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'webp', 'woff', 'woff2', 'ttf', 'eot', 'map'];
    if (in_array(strtolower($ext), $staticExts, true)) {
        return false; 
    }
}

// 2. Forward ALL other requests to index.php
$_GET['url'] = ltrim($uri, '/');
require __DIR__ . '/index.php';