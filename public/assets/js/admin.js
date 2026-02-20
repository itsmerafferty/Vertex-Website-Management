document.addEventListener('DOMContentLoaded', function () {
    // File Input Preview
    const fileInputs = document.querySelectorAll('.file-input-wrapper input[type="file"]');

    fileInputs.forEach(input => {
        const wrapper = input.closest('.file-input-wrapper');
        const label = wrapper.querySelector('.file-input-label');
        const originalContent = label.innerHTML;

        input.addEventListener('change', function (e) {
            const file = this.files[0];

            if (file) {
                // Check if it's an image
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        label.innerHTML = `
                            <img src="${e.target.result}" style="max-height: 150px; max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <div style="margin-top: 10px; font-size: 0.9rem; color: #4361ee;">${file.name}</div>
                        `;
                    }

                    reader.readAsDataURL(file);
                } else {
                    label.innerHTML = `
                        <i class="fa-solid fa-file-lines"></i>
                        <span>${file.name}</span>
                    `;
                }
                wrapper.style.borderColor = '#4361ee';
                wrapper.style.backgroundColor = '#f0f4ff';
            } else {
                label.innerHTML = originalContent;
                wrapper.style.borderColor = '';
                wrapper.style.backgroundColor = '';
            }
        });

        // Drag and Drop Visual Feedback
        wrapper.addEventListener('dragover', (e) => {
            e.preventDefault();
            wrapper.style.borderColor = '#4361ee';
            wrapper.style.backgroundColor = '#e0e7ff';
        });

        wrapper.addEventListener('dragleave', (e) => {
            e.preventDefault();
            wrapper.style.borderColor = '';
            wrapper.style.backgroundColor = '';
        });

        wrapper.addEventListener('drop', (e) => {
            e.preventDefault();
            wrapper.style.borderColor = '#4361ee';
            wrapper.style.backgroundColor = '#f0f4ff';

            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                // Trigger change event manually
                const event = new Event('change');
                input.dispatchEvent(event);
            }
        });
    });

    // Modal Logic
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    const modalCloses = document.querySelectorAll('[data-modal-close]');
    const overlays = document.querySelectorAll('.modal-overlay');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = trigger.getAttribute('data-modal-target');
            const modal = document.querySelector(targetId);
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            }
        });
    });

    function closeModal(modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    modalCloses.forEach(close => {
        close.addEventListener('click', () => {
            const modal = close.closest('.modal-overlay');
            closeModal(modal);
        });
    });

    overlays.forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeModal(overlay);
            }
        });
    });

    // Theme Toggle Logic
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = themeToggleBtn ? themeToggleBtn.querySelector('i') : null;
    const themeText = themeToggleBtn ? themeToggleBtn.querySelector('span') : null;

    // Check saved preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }

    function updateThemeIcon(theme) {
        if (!themeIcon) return;
        if (theme === 'dark') {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
            if (themeText) themeText.textContent = 'Light Mode';
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
            if (themeText) themeText.textContent = 'Dark Mode';
        }
    }

    // Edit Testimonial Modal Logic
    const editBtns = document.querySelectorAll('.edit-testimonial-btn');
    const editModal = document.getElementById('editTestimonialModal');
    const editForm = document.getElementById('editTestimonialForm');

    if (editBtns && editModal && editForm) {
        editBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const position = btn.dataset.position;
                const systemName = btn.dataset.systemName;
                const rating = btn.dataset.rating;
                const testimonial = btn.dataset.testimonial;
                const imagePath = btn.dataset.image;

                // Populate Form
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_position').value = position;
                document.getElementById('edit_system_name').value = systemName;
                document.getElementById('edit_rating').value = rating;
                document.getElementById('edit_testimonial').value = testimonial;

                // Image Preview
                const currentImageContainer = document.getElementById('current_image_preview');
                const currentImageImg = currentImageContainer.querySelector('img');

                if (imagePath) {
                    currentImageContainer.style.display = 'block';
                    currentImageImg.src = imagePath;
                } else {
                    currentImageContainer.style.display = 'none';
                }

                // Set Form Action (Controller handles POST to ?testimonials)
                editForm.action = '?testimonials';

                // Open Modal
                editModal.classList.add('show');
            });
        });
    }

    // Delete Testimonial Modal Logic
    const deleteBtns = document.querySelectorAll('.delete-testimonial-btn');
    const deleteModal = document.getElementById('deleteTestimonialModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    if (deleteBtns && deleteModal && confirmDeleteBtn) {
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                // Set the HREF of the confirm button for query-based routing
                confirmDeleteBtn.href = `?testimonials&action=delete&id=${id}`;
                deleteModal.classList.add('show');
            });
        });
    }

    // --- EMPLOYEE SECTION ---

    // Add Employee Modal
    const addEmployeeBtn = document.getElementById('addEmployeeBtn');
    const addEmployeeModal = document.getElementById('addEmployeeModal');

    if (addEmployeeBtn && addEmployeeModal) {
        addEmployeeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addEmployeeModal.classList.add('show');
        });
    }

    // Edit Employee Modal
    const editEmpBtns = document.querySelectorAll('.edit-employee-btn');
    const editEmpModal = document.getElementById('editEmployeeModal');
    const editEmpForm = document.getElementById('editEmployeeForm');

    if (editEmpBtns && editEmpModal && editEmpForm) {
        // Edit Employee Modal
        const editEmpButtons = document.querySelectorAll('.edit-employee-btn');
        const editEmpModal = document.querySelector('#editEmployeeModal');
        const editEmpForm = document.querySelector('#editEmployeeForm');

        if (editEmpButtons.length > 0 && editEmpModal) {
            // Find base path - In this query-based router, we just need the base current URL
            // We can get it from the window location or the form action
            const addEmpForm = document.querySelector('#addEmployeeModal form');
            let baseAction = '';
            if (addEmpForm) {
                baseAction = addEmpForm.getAttribute('action');
            }

            editEmpButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    const name = btn.getAttribute('data-name');
                    const position = btn.getAttribute('data-position');
                    const description = btn.getAttribute('data-description');
                    const type = btn.getAttribute('data-type');
                    const email = btn.getAttribute('data-email');
                    const linkedin = btn.getAttribute('data-linkedin');
                    const image = btn.getAttribute('data-image');

                    document.getElementById('edit_emp_id').value = id;
                    document.getElementById('edit_emp_name').value = name;
                    document.getElementById('edit_emp_position').value = position;
                    document.getElementById('edit_emp_description').value = description;
                    document.getElementById('edit_emp_type').value = type;
                    document.getElementById('edit_emp_email').value = email;
                    document.getElementById('edit_emp_linkedin').value = linkedin;

                    const imgPreview = document.getElementById('current_emp_image_preview');
                    if (image) {
                        imgPreview.querySelector('img').src = image;
                        imgPreview.style.display = 'block';
                    } else {
                        imgPreview.style.display = 'none';
                    }

                    // Update Form Action for query-based routing
                    // The controller handles POST based on ID presence, so same action URL is fine
                    // or we can add &action=update if strictly needed, but the controller in this app seems to handle update if 'id' is present in POST
                    editEmpForm.action = baseAction;

                    editEmpModal.classList.add('show');
                });
            });
        }
    }

    // Delete Employee Modal
    const deleteEmpBtns = document.querySelectorAll('.delete-employee-btn');
    const deleteEmpModal = document.getElementById('deleteEmployeeModal');
    const confirmDeleteEmpBtn = document.getElementById('confirmDeleteEmpBtn');

    if (deleteEmpBtns.length > 0 && deleteEmpModal && confirmDeleteEmpBtn) {
        const addEmpForm = document.querySelector('#addEmployeeModal form');
        let baseAction = '';
        if (addEmpForm) {
            baseAction = addEmpForm.getAttribute('action');
        }

        deleteEmpBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const type = btn.getAttribute('data-type');
                // Construct delete URL
                // Check if baseAction already has query params
                const separator = baseAction.includes('?') ? '&' : '?';
                confirmDeleteEmpBtn.href = `${baseAction}${separator}action=delete&id=${id}&type=${type}`;
                deleteEmpModal.classList.add('show');
            });
        });
    }

});


// Sidebar Submenu Logic
const submenuToggles = document.querySelectorAll('.sidebar-link.has-submenu');

// Restore state from localStorage
submenuToggles.forEach(toggle => {
    const submenuId = toggle.getAttribute('data-submenu-id');
    const submenu = toggle.nextElementSibling;

    if (submenuId && localStorage.getItem(`sidebar_submenu_${submenuId}`) === 'open') {
        if (submenu) {
            submenu.classList.add('show');
            toggle.classList.add('expanded');
        }
    }
});

submenuToggles.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const submenu = toggle.nextElementSibling;
        const submenuId = toggle.getAttribute('data-submenu-id');

        if (submenu) {
            // Toggle show class
            submenu.classList.toggle('show');
            toggle.classList.toggle('expanded');

            // Save state
            if (submenuId) {
                const isOpen = submenu.classList.contains('show');
                localStorage.setItem(`sidebar_submenu_${submenuId}`, isOpen ? 'open' : 'closed');
            }
        }
    });

    // Auto-expand if child is active (override localStorage if active, or just ensure it stays open?)
    // If active, it SHOULD be open regardless of localStorage usually, but user asked for persistence.
    // Let's say active state enforces open, and saves it as open.
    const submenu = toggle.nextElementSibling;
    if (submenu && (submenu.querySelector('a.active') || toggle.classList.contains('active'))) {
        submenu.classList.add('show');
        toggle.classList.add('expanded');
        // update storage to reflect it's forced open
        const submenuId = toggle.getAttribute('data-submenu-id');
        if (submenuId) {
            localStorage.setItem(`sidebar_submenu_${submenuId}`, 'open');
        }
    }
});
