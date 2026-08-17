<?php
/**
 * router.php – PHP built-in server front controller
 *
 * Usage:  php -S localhost:8000 router.php
 *
 * Static assets (css, js, images) are served directly.
 * Everything else is forwarded to index.php for routing.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing static files (css, js, images, etc.) directly
$requested = __DIR__ . $uri;
if ($uri !== '/' && file_exists($requested) && !is_dir($requested)) {
    $ext = pathinfo($requested, PATHINFO_EXTENSION);
    $staticExts = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'webp', 'woff', 'woff2', 'ttf', 'eot', 'map'];
    if (in_array(strtolower($ext), $staticExts, true)) {
        return false; // let the built-in server serve this static file
    }
}

// Forward all other requests to the front controller
$_GET['url'] = ltrim($uri, '/');
require __DIR__ . '/index.php';
