<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Testimonials</h1>
    <p class="page-subtitle">Manage client testimonials and reviews.</p>
</div>

<!-- Actions Bar -->
<div class="actions-bar">
    <div style="flex-grow: 1;"></div>
    <div>
        <!-- Trigger Modal -->
        <button id="addTestimonialBtn" class="btn-primary" data-modal-target="#addTestimonialModal">
            <i class="fa-solid fa-plus"></i> Add Testimonial
        </button>
    </div>
</div>

<!-- Testimonials Table -->
<div class="card">
    <div class="card-header">All Testimonials</div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>System Name</th>
                    <th>Rating</th>
                    <th>Testimonial</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="avatar" style="background: #e9ecef; color: #333; overflow: hidden; width: 40px; height: 40px;">
                                    <?php if (!empty($t['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($t['image']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <i class="fa-solid fa-user" style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <strong style="display: block; color: var(--text-color);"><?php echo htmlspecialchars($t['name']); ?></strong>
                                    <span style="font-size: 0.85rem; color: #6c757d;"><?php echo htmlspecialchars($t['position'] ?? ''); ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge" style="background-color: #eef2ff; color: #4361ee;">
                                <?php echo htmlspecialchars($t['system_name'] ?? 'Vertex Client'); ?>
                            </span>
                        </td>
                        <td>
                            <div style="color: #f59e0b; font-size: 0.9rem;">
                                <?php
                                $rating = (int)($t['rate'] ?? 5);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo ($i <= $rating) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                                }
                                ?>
                            </div>
                        </td>
                        <td style="max-width: 300px;">
                            <div title="<?php echo htmlspecialchars($t['testimonial']); ?>"
                                style="display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #4b5563; font-style: italic;">
                                "<?php echo htmlspecialchars($t['testimonial']); ?>"
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <button class="icon-btn edit-testimonial-btn"
                                    data-id="<?php echo $t['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($t['name']); ?>"
                                    data-position="<?php echo htmlspecialchars($t['position'] ?? ''); ?>"
                                    data-system-name="<?php echo htmlspecialchars($t['system_name'] ?? ''); ?>"
                                    data-rating="<?php echo $rating; ?>"
                                    data-testimonial="<?php echo htmlspecialchars($t['testimonial']); ?>"
                                    data-image="<?php echo htmlspecialchars($t['image'] ?? ''); ?>"
                                    title="Edit"
                                    style="font-size: 0.8rem; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 4px;">
                                    Edit
                                </button>
                                <button class="icon-btn delete-testimonial-btn"
                                    data-id="<?php echo $t['id']; ?>"
                                    title="Delete"
                                    style="font-size: 0.8rem; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 4px; color: #ef4444;">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($testimonials)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fa-regular fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            No testimonials found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Testimonial Modal -->
<div id="addTestimonialModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Add Testimonial</h3>
            <button class="modal-close" data-modal-close>&times;</button>
        </div>
        <div class="modal-body">
            <form action="?testimonials" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="store">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Client Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Ana Dela Cruz" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position</label>
                        <input type="text" name="position" class="form-control" placeholder="e.g. Chief Finance Officer">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">System Name</label>
                        <input type="text" name="system_name" class="form-control" placeholder="e.g. Vertex ERP">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rating (1-5) <span class="required">*</span></label>
                        <input type="number" name="rate" class="form-control" min="1" max="5" value="5" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Testimonial <span class="required">*</span></label>
                    <textarea name="testimonial" class="form-control" rows="2" placeholder="Enter the client's testimonial here..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Client Image</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="image" accept="image/*">
                        <div class="file-input-label">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Click or Drag to Upload Client Image</span>
                        </div>
                    </div>
                    <p class="form-text">Recommended size: 100x100px. Max size: 2MB.</p>
                </div>

                <div class="form-actions" style="margin-top: 20px; padding-top: 0; border-top: none;">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Testimonial Modal -->
<div id="editTestimonialModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Testimonial</h3>
            <button class="modal-close" data-modal-close>&times;</button>
        </div>
        <div class="modal-body">
            <form id="editTestimonialForm" action="?testimonials" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update"> <!-- Or handled by ID presence -->
                <input type="hidden" name="id" id="edit_id">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Client Name <span class="required">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position</label>
                        <input type="text" name="position" id="edit_position" class="form-control">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">System Name</label>
                        <input type="text" name="system_name" id="edit_system_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rating (1-5) <span class="required">*</span></label>
                        <input type="number" name="rate" id="edit_rating" class="form-control" min="1" max="5" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Testimonial <span class="required">*</span></label>
                    <textarea name="testimonial" id="edit_testimonial" class="form-control" rows="2" required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Client Image</label>
                    <div id="current_image_preview" style="margin-bottom: 10px; display: none;">
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
                    <p class="form-text">Leave blank to keep current image. Recommended size: 100x100px.</p>
                </div>

                <div class="form-actions" style="margin-top: 20px; padding-top: 0; border-top: none;">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteTestimonialModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 400px; text-align: center;">
        <div class="modal-body" style="padding: 30px;">
            <div style="width: 60px; height: 60px; background-color: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 20px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="modal-title" style="margin-bottom: 10px; font-size: 1.25rem;">Delete Testimonial?</h3>
            <p style="color: var(--text-muted); margin-bottom: 25px;">Are you sure you want to delete this testimonial? This action cannot be undone.</p>

            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn-primary" style="background-color: #ef4444; border: none; color: white;">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>