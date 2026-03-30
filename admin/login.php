<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

if (current_admin()) {
    redirect('admin/dashboard.php');
}

if (is_post() && isset($_POST['login'])) {
    $admin = authenticate_admin((string) ($_POST['email'] ?? ''), (string) ($_POST['password'] ?? ''));

    if ($admin) {
        login_admin($admin);
        flash('success', 'Welcome back, admin.');
        redirect('admin/dashboard.php');
    }

    flash('error', 'Wrong admin email or password.');
}

$errorMessage = flash('error');
$successMessage = flash('success');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/login.css')) ?>">
</head>
<body>
<div class="overlay"></div>
<div class="login-container">
    <div class="logo-area">
        <h2>Admin Login</h2>
    </div>

    <?php if ($errorMessage || $successMessage): ?>
        <p style="color: <?= $errorMessage ? '#f87171' : '#d4af37' ?>; text-align: center; margin-bottom: 18px; font-size: 14px;">
            <?= e($errorMessage ?: $successMessage) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="<?= e(url('admin/login.php')) ?>">
        <div class="input-group">
            <input type="email" name="email" placeholder="Admin Email" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login">Sign In</button>
    </form>

    <div class="signup-link" style="line-height: 1.7;">
        <!-- User login? <a href="<?= e(url('login.php')) ?>">Go to user sign in</a><br> -->
    </div>
</div>
</body>
</html>
