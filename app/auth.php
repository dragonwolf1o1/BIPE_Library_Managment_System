<?php

declare(strict_types=1);

function login_user(array $student): void
{
    session_regenerate_id(true);
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_id'] = (int) $student['id'];
    $_SESSION['user_email'] = $student['Email_Address'];
    $_SESSION['user_name'] = $student['Name'];
}

function login_admin(array $admin): void
{
    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['admin_email'] = $admin['email'];
}

function logout_all(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function current_user(): ?array
{
    static $user = false;

    if ($user !== false) {
        return $user;
    }

    if (empty($_SESSION['user_id'])) {
        $user = null;

        return null;
    }

    $user = db_one(
        'SELECT s.*, d.name AS Department, d.id AS department_id
         FROM student_table s
         LEFT JOIN departments d ON d.id = s.department_id
         WHERE s.id = ?',
        [(int) $_SESSION['user_id']],
        'i'
    );

    if (!$user) {
        unset($_SESSION['user_id'], $_SESSION['user_logged_in'], $_SESSION['user_email'], $_SESSION['user_name']);
    }

    return $user;
}

function current_admin(): ?array
{
    static $admin = false;

    if ($admin !== false) {
        return $admin;
    }

    if (empty($_SESSION['admin_id'])) {
        $admin = null;

        return null;
    }

    $admin = db_one('SELECT * FROM admins WHERE id = ?', [(int) $_SESSION['admin_id']], 'i');

    if (!$admin) {
        unset($_SESSION['admin_id'], $_SESSION['admin_logged_in'], $_SESSION['admin_name'], $_SESSION['admin_email']);
    }

    return $admin;
}

function require_user(): array
{
    $user = current_user();

    if (!$user) {
        flash('error', 'Please sign in to continue.');
        redirect('login.php');
    }

    return $user;
}

function require_admin(): array
{
    $admin = current_admin();

    if (!$admin) {
        flash('error', 'Admin access is required.');
        redirect('admin/login.php');
    }

    return $admin;
}
