<?php
$title = 'Dashboard — Vertex Admin';
include __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Welcome back, Admin.</p>
</div>

<div class="grid-view" style="grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));">
    <!-- Stats Cards -->
    <div class="card" style="padding: 20px; border-left: 4px solid #4361ee;">
        <h3 style="margin: 0; color: #6c757d; font-size: 0.9rem; font-weight: 500;">Total Employees</h3>
        <p style="font-size: 2rem; font-weight: 700; margin: 10px 0 0 0;"><?php echo $totalEmployees ?? 0; ?></p>
    </div>

    <div class="card" style="padding: 20px; border-left: 4px solid #3a0ca3;">
        <h3 style="margin: 0; color: #6c757d; font-size: 0.9rem; font-weight: 500;">Top Employees</h3>
        <p style="font-size: 2rem; font-weight: 700; margin: 10px 0 0 0;"><?php echo $topEmployeesCount ?? 0; ?></p>
    </div>

    <div class="card" style="padding: 20px; border-left: 4px solid #10b981;">
        <h3 style="margin: 0; color: #6c757d; font-size: 0.9rem; font-weight: 500;">Testimonials</h3>
        <p style="font-size: 2rem; font-weight: 700; margin: 10px 0 0 0;"><?php echo $testimonialsCount ?? 0; ?></p>
    </div>
</div>

<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        System Overview
    </div>
    <div style="padding: 20px;">
        <p>Welcome to the <strong>Vertex Website Management</strong> admin panel.</p>
        <p>Manage your website content efficiently using the sidebar menu.</p>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>