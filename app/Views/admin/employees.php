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
                            <div class="avatar" style="background: #e9ecef; color: #333; overflow: hidden; width: 60px; height: 60px;">
                                <?php if (!empty($emp['image'])): ?>
                                    <img src="public/<?php echo htmlspecialchars($emp['image']); ?>" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
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
                                <?php echo htmlspecialchars($emp['email']); ?>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($emp['linkedin'])): ?>
                                <?php echo htmlspecialchars($emp['linkedin']); ?>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <button class="icon-btn view-employee-btn"
                                    data-id="<?php echo $emp['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($emp['name']); ?>"
                                    data-position="<?php echo htmlspecialchars($emp['position'] ?? ''); ?>"
                                    data-description="<?php echo htmlspecialchars($emp['description'] ?? ''); ?>"
                                    data-email="<?php echo htmlspecialchars($emp['email'] ?? ''); ?>"
                                    data-linkedin="<?php echo htmlspecialchars($emp['linkedin'] ?? ''); ?>"
                                    data-image="<?php echo !empty($emp['image']) ? htmlspecialchars('public/' . $emp['image']) : ''; ?>"
                                    title="View Details"
                                    style="font-size: 0.8rem; border: 1px solid var(--primary-color); padding: 4px 8px; border-radius: 4px; color: var(--primary-color);">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="icon-btn edit-employee-btn"
                                    data-id="<?php echo $emp['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($emp['name']); ?>"
                                    data-position="<?php echo htmlspecialchars($emp['position'] ?? ''); ?>"
                                    data-description="<?php echo htmlspecialchars($emp['description'] ?? ''); ?>"
                                    data-type="<?php echo $filter; ?>"
                                    data-email="<?php echo htmlspecialchars($emp['email'] ?? ''); ?>"
                                    data-linkedin="<?php echo htmlspecialchars($emp['linkedin'] ?? ''); ?>"
                                    data-image="<?php echo !empty($emp['image']) ? htmlspecialchars('public/' . $emp['image']) : ''; ?>"
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
                        <img src="" style="max-height: 120px; border-radius: 6px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
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
                id: this.dataset.id,
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
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
            closeEmployeeDetailModal();
        }
    });
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>