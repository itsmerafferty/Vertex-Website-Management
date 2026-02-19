<?php
// ─── Auth helper ──────────────────────────────────────────────────────────────
function requireAuth(): void {
    if (empty($_SESSION['logged_in'])) {
        header('Location: ?login');
        exit;
    }
}

// ─── Login route ──────────────────────────────────────────────────────────────
if (isset($_GET['login'])) {
    // Already logged in → go straight to dashboard
    if (!empty($_SESSION['logged_in'])) {
        header('Location: ?admin');
        exit;
    }
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    $auth = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth->login();
    } else {
        $auth->showLogin();
    }
    exit;
}

// ─── Logout route ─────────────────────────────────────────────────────────────
if (isset($_GET['logout'])) {
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    $auth = new AuthController();
    $auth->logout();
    exit;
}

// ─── Protected routes (require login) ────────────────────────────────────────

// Admin dashboard route
if (isset($_GET['admin'])) {
    requireAuth();
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $adminController = new AdminController();
    $adminController->dashboard();
    exit;
}

// Employees route (combined top + regular with filter tabs)
if (isset($_GET['employees'])) {
    requireAuth();
    require_once __DIR__ . '/../app/Controllers/CombinedEmployeesController.php';
    $c = new CombinedEmployeesController();
    $c->index();
    exit;
}

// Legacy redirects — preserve old bookmarks
if (isset($_GET['top_employees'])) {
    requireAuth();
    header('Location: ?employees&filter=top');
    exit;
}

if (isset($_GET['regular_employees'])) {
    requireAuth();
    header('Location: ?employees&filter=regular');
    exit;
}

// Testimonials route
if (isset($_GET['testimonials'])) {
    requireAuth();
    require_once __DIR__ . '/../app/Controllers/TestimonialController.php';
    $c = new TestimonialController();
    $c->index();
    exit;
}

// Legacy admin employees route
if (isset($_GET['admin_employees'])) {
    requireAuth();
    header('Location: ?employees&filter=top');
    exit;
}

// Admin settings route
if (isset($_GET['admin_settings'])) {
    requireAuth();
    echo '<h2 style="font-family:Inter,Arial,sans-serif;text-align:center;margin-top:4rem;">Settings page coming soon.</h2>';
    exit;
}
