<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vertex Website Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --background: #f8fafc;
            --foreground: #18181b;
            --primary: #6366f1;
            --sidebar-bg: #fff;
            --sidebar-border: #e5e7eb;
            --sidebar-active: #f1f5f9;
            --card-bg: #fff;
            --border: #e5e7eb;
            --radius: 0.5rem;
        }
        body {
            background: var(--background);
            color: var(--foreground);
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            height: 100vh;
            padding: 2rem 0 0 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar h2 {
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0 0 1rem 0;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            padding: 0.75rem 2rem;
            color: var(--foreground);
            border-left: 4px solid transparent;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            font-size: 0.95rem;
        }
        .sidebar ul li.active, .sidebar ul li:hover {
            background: var(--sidebar-active);
            border-left: 4px solid var(--primary);
            color: var(--primary);
        }
        .main {
            flex: 1;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 2.5rem 2rem;
            min-width: 340px;
            text-align: center;
        }
        h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5em;
            color: var(--primary);
        }
        p { color: #52525b; margin: 0; }
        .module-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
            text-align: left;
        }
        .module-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            transition: box-shadow 0.15s, border-color 0.15s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .module-card:hover {
            box-shadow: 0 4px 16px rgba(99,102,241,0.12);
            border-color: var(--primary);
        }
        .module-card strong { display: block; font-size: 1rem; color: var(--primary); margin-bottom: 0.25rem; }
        .module-card span { font-size: 0.85rem; color: #52525b; }
    </style>
</head>
<body>
    <?php
    $activePage = 'admin';
    include __DIR__ . '/_sidebar.php';
    ?>
    <div class="main">
        <div class="card">
            <h1>Welcome to the Admin Dashboard</h1>
            <p>Use the sidebar or the shortcuts below to manage website content.</p>
            <div class="module-grid">
                <a href="?employees&filter=top" class="module-card">
                    <strong>Top Employees</strong>
                    <span>Manage featured employee profiles</span>
                </a>
                <a href="?employees&filter=regular" class="module-card">
                    <strong>Regular Employees</strong>
                    <span>Manage standard employee profiles</span>
                </a>
                <a href="?testimonials" class="module-card">
                    <strong>Testimonials</strong>
                    <span>Manage client &amp; user testimonials</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
