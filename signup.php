<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

if (current_user()) {
    redirect('user_dashboard.php');
}

if (is_post() && isset($_POST['signup'])) {
    remember_input($_POST);
    $result = register_student($_POST);

    if ($result['success']) {
        forget_input();
        flash('success', $result['message'] . ' Please log in.');
        redirect('login.php');
    }

    flash('error', $result['message']);
}

$errorMessage = flash('error');
$departments = departments_all();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/signup.css')) ?>">
</head>
<body>
<div class="overlay"></div>
<div class="signup-container">
    <div class="logo-area">
        <h2>Create your account</h2>
    </div>

    <?php if ($errorMessage): ?>
        <p style="color: #f87171; text-align: center; margin-bottom: 15px; font-size: 13px;">
            <?= e($errorMessage) ?>
        </p>
    <?php endif; ?>

    <form id="signup-form" method="POST" action="<?= e(url('signup.php')) ?>">
        <div class="form-grid">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" value="<?= e(old('name')) ?>" required>
            </div>
            <div class="input-group">
                <input type="text" name="course" placeholder="Course" value="<?= e(old('course')) ?>" required>
            </div>
            <div class="input-group">
                <input type="text" name="semester" placeholder="Semester" value="<?= e(old('semester')) ?>" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" value="<?= e(old('email')) ?>" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="number" min="1" max="10" name="no_book_issued" placeholder="Borrow Limit" value="<?= e(old('no_book_issued', '3')) ?>" required>
            </div>
            <div class="input-group select-wrapper">
                <?php $currentDepartmentId = old('department_id'); ?>
                <select name="department_id" required>
                    <option value="" disabled <?= $currentDepartmentId === '' ? 'selected' : '' ?>>Select Department</option>
                    <?php foreach ($departments as $department): ?>
                        <option value="<?= e((string) $department['id']) ?>" <?= selected((string) $department['id'], $currentDepartmentId) ?>>
                            <?= e($department['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" name="signup">Sign Up</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="<?= e(url('login.php')) ?>">Sign in</a>
    </div>
</div>
</body>
</html>
