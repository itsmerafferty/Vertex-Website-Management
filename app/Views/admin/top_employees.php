<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Employees — Vertex Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg: #f8fafc;
            --fg: #18181b;
            --primary: #6366f1;
            --primary-dark: #4338ca;
            --sidebar-bg: #fff;
            --border: #e5e7eb;
            --sidebar-active: #f1f5f9;
            --card-bg: #fff;
            --radius: 0.5rem;
            --danger: #ef4444;
            --success: #22c55e;
            --muted: #52525b;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            background: var(--bg);
            color: var(--fg);
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
        }
        /* Sidebar */
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            min-height: 100vh;
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
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li {
            padding: 0.75rem 2rem;
            color: var(--fg);
            border-left: 4px solid transparent;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            font-size: 0.95rem;
        }
        .sidebar ul li.active,
        .sidebar ul li:hover {
            background: var(--sidebar-active);
            border-left-color: var(--primary);
            color: var(--primary);
        }
        /* Main */
        .main {
            flex: 1;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-width: 0;
        }
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: background 0.15s, color 0.15s;
        }
        .btn-primary  { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: #e0e7ff; color: var(--primary); }
        .btn-secondary:hover { background: #c7d2fe; }
        .btn-danger   { background: #fee2e2; color: var(--danger); }
        .btn-danger:hover { background: #fecaca; }
        .btn-sm { padding: 0.3rem 0.8rem; font-size: 0.82rem; }
        /* Card */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 1.75rem;
        }
        .card h2 { margin: 0 0 1.25rem 0; font-size: 1.1rem; color: var(--fg); }
        /* Form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem 1.5rem;
        }
        .form-group { display: flex; flex-direction: column; gap: 0.35rem; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 0.85rem; font-weight: 600; color: var(--muted); }
        input[type="text"],
        input[type="email"],
        input[type="url"],
        textarea {
            padding: 0.55rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--fg);
            background: #fafafa;
            transition: border-color 0.15s;
            width: 100%;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
        }
        textarea { resize: vertical; min-height: 80px; }
        .form-actions { display: flex; gap: 0.75rem; margin-top: 0.5rem; }
        .img-preview {
            width: 80px; height: 80px;
            object-fit: cover;
            border-radius: var(--radius);
            border: 2px solid var(--border);
            margin-top: 0.25rem;
        }
        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        thead th {
            text-align: left;
            padding: 0.6rem 0.75rem;
            background: var(--bg);
            border-bottom: 2px solid var(--border);
            font-weight: 600;
            color: var(--muted);
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        tbody tr { border-bottom: 1px solid var(--border); }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafafa; }
        tbody td { padding: 0.75rem; vertical-align: middle; }
        .tbl-img {
            width: 48px; height: 48px;
            object-fit: cover;
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }
        .tbl-img-placeholder {
            width: 48px; height: 48px;
            background: #e0e7ff;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
        }
        .actions { display: flex; gap: 0.5rem; }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--muted);
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<?php
$activePage = 'top_employees';
include __DIR__ . '/_sidebar.php';
?>

<div class="main">
    <div class="page-header">
        <h1>Top Employees</h1>
        <?php if ($action !== 'new' && $action !== 'edit'): ?>
        <a href="?top_employees&action=new" class="btn btn-primary">+ Add Employee</a>
        <?php endif; ?>
    </div>

    <?php if ($action === 'new' || $action === 'edit'): ?>
    <div class="card">
        <h2><?= $action === 'edit' ? 'Edit Employee' : 'Add New Employee' ?></h2>
        <form method="POST" action="?top_employees" enctype="multipart/form-data">
            <?php if ($action === 'edit' && $editItem): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editItem['id']) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" required
                        value="<?= htmlspecialchars($editItem['name'] ?? '') ?>"
                        placeholder="Full name">
                </div>
                <div class="form-group">
                    <label for="position">Position <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="position" name="position" required
                        value="<?= htmlspecialchars($editItem['position'] ?? '') ?>"
                        placeholder="e.g. Senior Engineer">
                </div>
                <div class="form-group">
                    <label for="email">Email Link</label>
                    <input type="email" id="email" name="email"
                        value="<?= htmlspecialchars($editItem['email'] ?? '') ?>"
                        placeholder="employee@example.com">
                </div>
                <div class="form-group">
                    <label for="linkedin">LinkedIn Link</label>
                    <input type="url" id="linkedin" name="linkedin"
                        value="<?= htmlspecialchars($editItem['linkedin'] ?? '') ?>"
                        placeholder="https://linkedin.com/in/...">
                </div>
                <div class="form-group full">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                        placeholder="Brief bio or description..."><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                </div>
                <div class="form-group full">
                    <label for="image">Profile Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <?php if (!empty($editItem['image'])): ?>
                    <img src="<?= htmlspecialchars($editItem['image']) ?>" alt="Current" class="img-preview">
                    <small style="color:var(--muted)">Leave blank to keep current image.</small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $action === 'edit' ? 'Save Changes' : 'Add Employee' ?>
                </button>
                <a href="?top_employees" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="card">
        <h2>All Top Employees (<?= count($employees) ?>)</h2>
        <?php if (empty($employees)): ?>
        <div class="empty-state">No top employees added yet. Click "+ Add Employee" to get started.</div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>LinkedIn</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $emp): ?>
                <tr>
                    <td>
                        <?php if (!empty($emp['image'])): ?>
                        <img src="<?= htmlspecialchars($emp['image']) ?>" alt="" class="tbl-img">
                        <?php else: ?>
                        <div class="tbl-img-placeholder">&#128100;</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($emp['name']) ?></strong></td>
                    <td><?= htmlspecialchars($emp['position']) ?></td>
                    <td>
                        <?php if (!empty($emp['email'])): ?>
                        <a href="mailto:<?= htmlspecialchars($emp['email']) ?>" style="color:var(--primary)">
                            <?= htmlspecialchars($emp['email']) ?>
                        </a>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($emp['linkedin'])): ?>
                        <a href="<?= htmlspecialchars($emp['linkedin']) ?>" target="_blank" style="color:var(--primary)">View</a>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="?top_employees&action=edit&id=<?= urlencode($emp['id']) ?>"
                               class="btn btn-secondary btn-sm">Edit</a>
                            <a href="?top_employees&action=delete&id=<?= urlencode($emp['id']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete <?= htmlspecialchars(addslashes($emp['name'])) ?>? This cannot be undone.')">
                               Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
