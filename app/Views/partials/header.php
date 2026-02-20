<?php
$basePath = dirname($_SERVER['SCRIPT_NAME']);
// Normalize slashes
$basePath = str_replace('\\', '/', $basePath);
if ($basePath === '/') $basePath = '';

function isActive($key, $val = null)
{
    if ($val !== null) {
        return (isset($_GET[$key]) && $_GET[$key] === $val) ? 'active' : '';
    }
    return isset($_GET[$key]) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Vertex Admin'; ?></title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>/assets/css/admin.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- JS -->
    <script src="<?php echo $basePath; ?>/assets/js/admin.js" defer></script>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            VertexAdmin
        </div>
        <ul class="sidebar-menu main-menu">
            <li>
                <a href="?admin" class="<?php echo isActive('admin'); ?>">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link has-submenu <?php echo isActive('employees'); ?>" data-submenu-id="employees">
                    <div class="sidebar-link-content">
                        <i class="fa-solid fa-users"></i> <span>Employees</span>
                    </div>
                    <i class="fa-solid fa-chevron-down submenu-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="?employees&filter=top" class="<?php echo isActive('filter', 'top'); ?>">
                            <i class="fa-solid fa-star"></i> Top Employees
                        </a>
                    </li>
                    <li>
                        <a href="?employees&filter=regular" class="<?php echo isActive('filter', 'regular'); ?>">
                            <i class="fa-solid fa-user-group"></i> Regular Employees
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="?testimonials" class="<?php echo isActive('testimonials'); ?>">
                    <i class="fa-solid fa-comments"></i> Testimonials
                </a>
            </li>

        </ul>
        <ul class="sidebar-menu sidebar-footer">
            <li>
                <a href="#" id="theme-toggle">
                    <i class="fa-solid fa-moon"></i> <span>Dark Mode</span>
                </a>
            </li>
            <li>
                <a href="?logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <header class="top-bar">
            <div class="toggle-sidebar">
            </div>

            <div class="user-profile">
                <?php
                $displayText = 'User';
                if (isset($_SESSION['user'])) {
                    $firstName = $_SESSION['user']['user_fname'] ?? '';
                    $lastName  = $_SESSION['user']['user_lname'] ?? '';
                    $fullName  = trim("$firstName $lastName");

                    if ($fullName !== '') {
                        $displayText = $fullName;
                    }
                }
                ?>
                <span class="user-name"><strong><?php echo htmlspecialchars($displayText); ?></strong></span>
                <div class="avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-wrapper">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>