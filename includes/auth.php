<?php
/**
 * Authentication & Session Management Helpers (BurmaLab-Web)
 */

if (session_status() === PHP_SESSION_NONE) {
    $cookieParams = session_get_cookie_params();
    $cookieParams['lifetime'] = 0;
    $cookieParams['path']     = '/'; // Crucial for clean routing across subdirectories/routes
    $cookieParams['domain']   = '';
    $cookieParams['secure']   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $cookieParams['httponly'] = true;
    $cookieParams['samesite'] = 'Lax';
    session_set_cookie_params($cookieParams);
    session_start();
}

/**
 * Check if a user is currently logged in.
 */
function is_authenticated(): bool {
    return !empty($_SESSION['user_id']);
}

/**
 * Enforce authentication on protected routes.
 */
function require_auth(): void {
    if (!is_authenticated()) {
        header('Location: /login');
        exit;
    }
}

/**
 * Enforce guest access (prevent logged in users from visiting /login or /signup).
 */
function require_guest(): void {
    if (is_authenticated()) {
        header('Location: /home');
        exit;
    }
}

/**
 * Return current session user details or null.
 */
function current_user(): ?array {
    if (!is_authenticated()) {
        return null;
    }
    return [
        'id'       => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? '',
        'email'    => $_SESSION['email'] ?? '',
    ];
}

/**
 * Set a flash notification message.
 */
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear the active flash message.
 */
function get_flash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Securely initialize user session upon successful authentication.
 */
function login_user(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email']    = $user['email'];
}

/**
 * Destroy active user session.
 */
function logout_user(): void {
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}