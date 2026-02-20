<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Employees</h1>
    <p class="page-subtitle">Manage and view registered employees.</p>
</div>

<!-- Actions Bar -->
<div class="actions-bar">
    <form action="" method="GET" style="margin: 0;">
        <input type="hidden" name="employees" value="">
        <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter ?? 'top'); ?>">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="q" placeholder="Search employees..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
        </div>
    </form>

    <div style="display: flex; gap: 10px;">
        <button id="addEmployeeBtn" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add Employee
        </button>
    </div>
</div>

<!-- Content Area -->
<!-- Employees Table -->
<div class="card">
    <div class="card-header">
        <?php
        if ($filter === 'top') echo 'Top Employees';
        elseif ($filter === 'regular') echo 'Regular Employees';
        else echo 'All Employees';
        ?>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Description</th>
                    <th>Email Link</th>
                    <th>LinkedIn Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($employees as $emp):
                ?>
                    <tr>
                        <td>
                            <div class="avatar" style="background: #e9ecef; color: #333; overflow: hidden; width: 40px; height: 40px;">
                                <?php if (!empty($emp['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($emp['image']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <?php echo substr($emp['name'], 0, 1); ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($emp['name']); ?></strong>
                        </td>
                        <td><?php echo htmlspecialchars($emp['position'] ?? 'N/A'); ?></td>
                        <td>
                            <span title="<?php echo htmlspecialchars($emp['description']); ?>">
                                <?php echo htmlspecialchars(mb_strimwidth($emp['description'], 0, 50, "...")); ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($emp['email'])): ?>
                                <a href="mailto:<?php echo htmlspecialchars($emp['email']); ?>" style="color: var(--primary-color); text-decoration: none; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-envelope"></i> Link
                                </a>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($emp['linkedin'])): ?>
                                <a href="<?php echo htmlspecialchars($emp['linkedin']); ?>" target="_blank" style="color: #0077b5; text-decoration: none; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-brands fa-linkedin"></i> LinkedIn
                                </a>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <button class="icon-btn edit-employee-btn"
                                    data-id="<?php echo $emp['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($emp['name']); ?>"
                                    data-position="<?php echo htmlspecialchars($emp['position'] ?? ''); ?>"
                                    data-description="<?php echo htmlspecialchars($emp['description'] ?? ''); ?>"
                                    data-type="<?php echo $filter; ?>"
                                    data-email="<?php echo htmlspecialchars($emp['email'] ?? ''); ?>"
                                    data-linkedin="<?php echo htmlspecialchars($emp['linkedin'] ?? ''); ?>"
                                    data-image="<?php echo htmlspecialchars($emp['image'] ?? ''); ?>"
                                    title="Edit"
                                    style="font-size: 0.8rem; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 4px;">
                                    Edit
                                </button>
                                <button class="icon-btn delete-employee-btn"
                                    data-id="<?php echo $emp['id']; ?>"
                                    data-type="<?php echo $filter; ?>"
                                    title="Delete"
                                    style="font-size: 0.8rem; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 4px; color: #ef4444;">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($employees)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                            No employees found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Employee Modal -->
<div id="addEmployeeModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Add Employee</h3>
            <button class="modal-close" data-modal-close>&times;</button>
        </div>
        <div class="modal-body">
            <form action="?employees&filter=<?php echo $filter; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="<?php echo htmlspecialchars($filter); ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Employee Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position <span class="required">*</span></label>
                        <input type="text" name="position" class="form-control" placeholder="e.g. Software Engineer" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description <span class="required">*</span></label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Brief description..." required></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Email Link</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">LinkedIn Link</label>
                        <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Employee Image</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="image" accept="image/*">
                        <div class="file-input-label">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Click or Drag to Upload Image</span>
                        </div>
                    </div>
                    <p class="form-text">Recommended size: 200x200px. Max size: 2MB.</p>
                </div>

                <div class="form-actions" style="margin-top: 15px; padding-top: 0; border-top: none;">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Employee</h3>
            <button class="modal-close" data-modal-close>&times;</button>
        </div>
        <div class="modal-body">
            <form id="editEmployeeForm" action="?employees&filter=<?php echo $filter; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_emp_id">
                <input type="hidden" name="type" id="edit_emp_type">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Employee Name <span class="required">*</span></label>
                        <input type="text" name="name" id="edit_emp_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position <span class="required">*</span></label>
                        <input type="text" name="position" id="edit_emp_position" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description <span class="required">*</span></label>
                    <textarea name="description" id="edit_emp_description" class="form-control" rows="2" required></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Email Link</label>
                        <input type="email" name="email" id="edit_emp_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">LinkedIn Link</label>
                        <input type="url" name="linkedin" id="edit_emp_linkedin" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Employee Image</label>
                    <div id="current_emp_image_preview" style="margin-bottom: 10px; display: none;">
                        <img src="" style="max-height: 80px; border-radius: 6px;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Current Image</span>
                    </div>
                    <div class="file-input-wrapper">
                        <input type="file" name="image" accept="image/*">
                        <div class="file-input-label">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Click or Drag to Upload New Image</span>
                        </div>
                    </div>
                    <p class="form-text">Leave blank to keep current image. Recommended size: 200x200px.</p>
                </div>

                <div class="form-actions" style="margin-top: 15px; padding-top: 0; border-top: none;">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Update Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Employee Modal -->
<div id="deleteEmployeeModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 400px; text-align: center;">
        <div class="modal-body" style="padding: 30px;">
            <div style="width: 60px; height: 60px; background-color: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 20px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="modal-title" style="margin-bottom: 10px; font-size: 1.25rem;">Delete Employee?</h3>
            <p style="color: var(--text-muted); margin-bottom: 25px;">Are you sure you want to delete this employee? This action cannot be undone.</p>

            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                <a href="#" id="confirmDeleteEmpBtn" class="btn-primary" style="background-color: #ef4444; border: none; color: white;">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>