<?php
$activePage = $activePage ?? '';
?>
<div class="sidebar" style="background: #0f172a; border-right: 1px solid rgba(255,255,255,0.05);">
    <div class="sidebar-logo" style="color: #c5a059;">
        <i class="fas fa-crown"></i> LMS Admin
    </div>
    <div class="nav-links">
        <a href="<?= e(url('admin/dashboard.php')) ?>" class="<?= $activePage === 'dashboard' ? 'active' : '' ?>"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="<?= e(url('admin/students.php')) ?>" class="<?= $activePage === 'students' ? 'active' : '' ?>"><i class="fas fa-users"></i> Manage Students</a>
        <a href="<?= e(url('admin/books.php')) ?>" class="<?= $activePage === 'books' ? 'active' : '' ?>"><i class="fas fa-book"></i> Manage Books</a>
        <a href="<?= e(url('admin/issues.php')) ?>" class="<?= $activePage === 'issues' ? 'active' : '' ?>"><i class="fas fa-exchange-alt"></i> Issue / Return</a>
        <a href="<?= e(url('admin/fines.php')) ?>" class="<?= $activePage === 'fines' ? 'active' : '' ?>"><i class="fas fa-file-invoice-dollar"></i> Fines & Reports</a>
        <a href="<?= e(url('admin/settings.php')) ?>" class="<?= $activePage === 'settings' ? 'active' : '' ?>"><i class="fas fa-cog"></i> Settings</a>
    </div>
</div>
