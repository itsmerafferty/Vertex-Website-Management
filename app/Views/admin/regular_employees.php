<?php
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = str_replace('\\', '/', $basePath);
if ($basePath === '/') $basePath = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regular Employees — Vertex Admin</title>
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
        .sidebar h2 { text-align: center; font-size: 1.25rem; font-weight: 700; color: var(--primary); margin: 0 0 1rem 0; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li {
            padding: 0.75rem 2rem;
            color: var(--fg);
            border-left: 4px solid transparent;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            font-size: 0.95rem;
        }
        .sidebar ul li.active, .sidebar ul li:hover {
            background: var(--sidebar-active);
            border-left-color: var(--primary);
            color: var(--primary);
        }
        .main { flex: 1; padding: 2.5rem 2rem; display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; }
        .page-header { display: flex; align-items: center; justify-content: space-between; }
        .page-header h1 { font-size: 1.6rem; font-weight: 700; color: var(--primary); margin: 0; }
        .btn { display: inline-block; padding: 0.5rem 1.25rem; border-radius: var(--radius); font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: background 0.15s; }
        .btn-primary  { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: #e0e7ff; color: var(--primary); }
        .btn-secondary:hover { background: #c7d2fe; }
        .btn-danger   { background: #fee2e2; color: var(--danger); }
        .btn-danger:hover { background: #fecaca; }
        .btn-sm { padding: 0.3rem 0.8rem; font-size: 0.82rem; }
        .card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 1.75rem; }
        .card h2 { margin: 0 0 1.25rem 0; font-size: 1.1rem; color: var(--fg); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem 1.5rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.35rem; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 0.85rem; font-weight: 600; color: var(--muted); }
        input[type="text"], input[type="email"], input[type="url"], textarea {
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
        input:focus, textarea:focus { outline: none; border-color: var(--primary); background: #fff; }
        textarea { resize: vertical; min-height: 80px; }
        .form-actions { display: flex; gap: 0.75rem; margin-top: 0.5rem; }
        .img-preview { width: 120px; height: 120px; object-fit: cover; border-radius: var(--radius); border: 2px solid var(--border); margin-top: 0.25rem; transition: transform 0.2s, box-shadow 0.2s; }
        .img-preview:hover { transform: scale(1.03); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        thead th { text-align: left; padding: 0.6rem 0.75rem; background: var(--bg); border-bottom: 2px solid var(--border); font-weight: 600; color: var(--muted); font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.04em; }
        tbody tr { border-bottom: 1px solid var(--border); }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafafa; }
        tbody td { padding: 0.75rem; vertical-align: middle; }
        .tbl-img { width: 80px; height: 80px; object-fit: cover; border-radius: var(--radius); border: 1px solid var(--border); transition: transform 0.2s, box-shadow 0.2s; }
        .tbl-img:hover { transform: scale(1.03); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .tbl-img-placeholder { width: 80px; height: 80px; background: #e0e7ff; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary); }
        .image-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); }
        .image-modal-content { margin: auto; display: block; max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        .image-modal-close { position: absolute; top: 20px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; }
        .image-modal-close:hover { color: #bbb; }
        .actions { display: flex; gap: 0.5rem; }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted); font-size: 0.95rem; }
    </style>
</head>
<body>

<?php
$activePage = 'regular_employees';
include __DIR__ . '/_sidebar.php';
?>

<div class="main">
    <div class="page-header">
        <h1>Regular Employees</h1>
        <?php if ($action !== 'new' && $action !== 'edit'): ?>
        <a href="?regular_employees&action=new" class="btn btn-primary">+ Add Employee</a>
        <?php endif; ?>
    </div>

    <?php if ($action === 'new' || $action === 'edit'): ?>
    <div class="card">
        <h2><?= $action === 'edit' ? 'Edit Employee' : 'Add New Employee' ?></h2>
        <form method="POST" action="?regular_employees" enctype="multipart/form-data">
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
                        placeholder="e.g. Marketing Specialist">
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
                    <img src="public/<?= htmlspecialchars($editItem['image']) ?>" alt="Current" class="img-preview">
                    <small style="color:var(--muted); display:block;">Leave blank to keep current image.</small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $action === 'edit' ? 'Save Changes' : 'Add Employee' ?>
                </button>
                <a href="?regular_employees" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="card">
        <h2>All Regular Employees (<?= count($employees) ?>)</h2>
        <?php if (empty($employees)): ?>
        <div class="empty-state">No regular employees added yet. Click "+ Add Employee" to get started.</div>
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
                        <img src="public/<?= htmlspecialchars($emp['image']) ?>" alt="<?= htmlspecialchars($emp['name']) ?>" class="tbl-img">
                        <?php else: ?>
                        <div class="tbl-img-placeholder">&#128100;</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($emp['name']) ?></strong></td>
                    <td><?= htmlspecialchars($emp['position']) ?></td>
                    <td>
                        <?php if (!empty($emp['email'])): ?>
                        <?= htmlspecialchars($emp['email']) ?>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($emp['linkedin'])): ?>
                        <?= htmlspecialchars($emp['linkedin']) ?>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-primary btn-sm view-employee-btn"
                                data-name="<?= htmlspecialchars($emp['name']) ?>"
                                data-position="<?= htmlspecialchars($emp['position']) ?>"
                                data-description="<?= htmlspecialchars($emp['description']) ?>"
                                data-email="<?= htmlspecialchars($emp['email'] ?? '') ?>"
                                data-linkedin="<?= htmlspecialchars($emp['linkedin'] ?? '') ?>"
                                data-image="<?= !empty($emp['image']) ? htmlspecialchars('public/' . $emp['image']) : '' ?>">
                                <i class="fa-solid fa-eye"></i> View
                            </button>
                            <a href="?regular_employees&action=edit&id=<?= urlencode($emp['id']) ?>"
                               class="btn btn-secondary btn-sm">Edit</a>
                            <a href="?regular_employees&action=delete&id=<?= urlencode($emp['id']) ?>"
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

<!-- Image Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
    <img class="image-modal-content" id="modalImage">
</div>

<!-- Employee Detail Modal -->
<div id="employeeDetailModal" class="employee-detail-modal">
    <div class="employee-detail-overlay" onclick="closeEmployeeDetailModal()"></div>
    <div class="employee-detail-card">
        <button class="employee-detail-close" onclick="closeEmployeeDetailModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="employee-detail-image">
            <img id="detailEmployeeImage" src="" alt="Employee Photo">
        </div>
        
        <div class="employee-detail-content">
            <h2 id="detailEmployeeName" class="employee-detail-name"></h2>
            <span id="detailEmployeePosition" class="employee-detail-position"></span>
            <p id="detailEmployeeDescription" class="employee-detail-description"></p>
            
            <div class="employee-detail-socials">
                <a id="detailEmployeeEmail" href="" class="employee-social-btn email-btn" style="display: none;">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Email</span>
                </a>
                <a id="detailEmployeeLinkedIn" href="" target="_blank" class="employee-social-btn linkedin-btn" style="display: none;">
                    <i class="fa-brands fa-linkedin"></i>
                    <span>LinkedIn</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('imageModal').style.display = 'block';
    document.getElementById('modalImage').src = src;
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

function openEmployeeDetailModal(employee) {
    const modal = document.getElementById('employeeDetailModal');
    const body = document.body;
    
    // Populate modal data
    const defaultImage = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"%3E%3Crect width="400" height="400" fill="%23e0e7ff"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="120" fill="%234361ee"%3E' + (employee.name ? employee.name.charAt(0).toUpperCase() : '?') + '%3C/text%3E%3C/svg%3E';
    
    document.getElementById('detailEmployeeImage').src = employee.image || defaultImage;
    document.getElementById('detailEmployeeName').textContent = employee.name || 'Unknown';
    document.getElementById('detailEmployeePosition').textContent = employee.position || 'N/A';
    document.getElementById('detailEmployeeDescription').textContent = employee.description || 'No description available.';
    
    // Handle email button
    const emailBtn = document.getElementById('detailEmployeeEmail');
    if (employee.email) {
        emailBtn.href = 'mailto:' + employee.email;
        emailBtn.style.display = 'flex';
    } else {
        emailBtn.style.display = 'none';
    }
    
    // Handle LinkedIn button
    const linkedInBtn = document.getElementById('detailEmployeeLinkedIn');
    if (employee.linkedin) {
        linkedInBtn.href = employee.linkedin;
        linkedInBtn.style.display = 'flex';
    } else {
        linkedInBtn.style.display = 'none';
    }
    
    // Show modal with animation
    modal.classList.add('show');
    body.style.overflow = 'hidden';
}

function closeEmployeeDetailModal() {
    const modal = document.getElementById('employeeDetailModal');
    const body = document.body;
    
    modal.classList.remove('show');
    body.style.overflow = '';
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // View employee detail buttons
    const viewBtns = document.querySelectorAll('.view-employee-btn');
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const employee = {
                name: this.dataset.name,
                position: this.dataset.position,
                description: this.dataset.description,
                email: this.dataset.email,
                linkedin: this.dataset.linkedin,
                image: this.dataset.image
            };
            openEmployeeDetailModal(employee);
        });
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
        closeEmployeeDetailModal();
    }
});
</script>

</body>
</html>
