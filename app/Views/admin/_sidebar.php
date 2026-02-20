<?php
// $activePage should be set by the including view
$activePage = $activePage ?? '';
$nav = [
    'admin'          => 'Dashboard',
    'employees'      => 'Employees',
    'testimonials'   => 'Testimonials',
    'admin_settings' => 'Settings',
];

$sessionUser = $_SESSION['user'] ?? [];
$firstName   = $sessionUser['user_fname'] ?? '';
$lastName    = $sessionUser['user_lname'] ?? '';
$displayName = trim("$firstName $lastName") ?: ($sessionUser['user_email'] ?? 'Admin');
$displayDept = isset($sessionUser['user_department']) ? 'Dept. ' . $sessionUser['user_department'] : '';
?>
<div class="sidebar">
    <h2>Admin</h2>
    <ul>
        <?php foreach ($nav as $key => $label): ?>
            <li onclick="window.location='?<?= $key ?>'"
                <?= $activePage === $key ? ' class="active"' : '' ?>>
                <?= htmlspecialchars($label) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <div style="margin-top:auto;padding:1.25rem 1.5rem;border-top:1px solid #e5e7eb;">
        <div style="font-size:0.82rem;font-weight:600;color:#18181b;margin-bottom:0.15rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            <?= htmlspecialchars($displayName) ?>
        </div>
        <?php if ($displayDept): ?>
            <div style="font-size:0.78rem;color:#6366f1;margin-bottom:0.6rem;">
                <?= htmlspecialchars($displayDept) ?>
            </div>
        <?php endif; ?>
        <a href="?logout" style="font-size:0.82rem;color:#ef4444;text-decoration:none;font-weight:500;">
            Sign out
        </a>
    </div>
</div>