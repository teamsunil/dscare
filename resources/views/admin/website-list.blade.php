<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Websites Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- Beautiful Header -->
    <header class="main-header">
        <div class="header-blur-bg"></div>
        <div class="container-fluid">
            <div class="header-content">
                <!-- Logo Section -->
                <div class="logo-section">
                    <div class="logo-icon">
                        <img src="{{ asset('assets/images/dotsquareLogo.png') }}" alt="Dotsquares Logo"
                            class="logo-img">
                    </div>
                    <span class="dashboard-text">Dashboard</span>
                    {{-- <div class="logo-text">
                        <h2>DS Care</h2>
                        <span>Dashboard</span>
                    </div> --}}
                </div>

                <!-- Navigation Menu -->
                <nav class="main-nav">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-globe"></i>
                        <span>Websites</span>
                    </a>
                </nav>

                <!-- User Profile Section -->
                <div class="user-profile">
                    <div class="user-info">
                        @php
                            $user = auth()->user();
                            $initials = $user
                                ? strtoupper(
                                    substr($user->name, 0, 1) .
                                        (isset(explode(' ', $user->name)[1])
                                            ? substr(explode(' ', $user->name)[1], 0, 1)
                                            : ''),
                                )
                                : '';
                        @endphp
                        <div class="user-avatar">
                            <span class="avatar">{{ $initials }}</span>
                            <div class="status-indicator"></div>
                        </div>
                        <div class="user-details">
                            <span class="user-name"> {{ optional(auth()->user())->name }}</span>
                            <span class="user-role">Administrator</span>
                        </div>
                        <button class="user-menu-btn">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>

                    <!-- User Dropdown Menu -->
                    <div class="user-dropdown">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-question-circle"></i>
                            <span>Help</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Decorative Elements -->
        <div class="header-decoration-1"></div>
        <div class="header-decoration-2"></div>
        <div class="header-decoration-3"></div>
    </header>

    <div class="dashboard-container">
        <!-- Floating Decorative Elements -->
        <div class="floating-element-1"></div>
        <div class="floating-element-2"></div>
        <div class="floating-element-3"></div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="content-wrapper">
            <div class="container-fluid px-4">
                <!-- Header Section -->
                <div class="header-section">
                    <h1 class="dashboard-title">
                        <i class="fas fa-globe"></i>
                        Dashboard
                    </h1>
                    <p class="dashboard-subtitle">Manage and monitor your websites from a single, beautiful interface
                    </p>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="search-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" id="websiteSearch"
                                placeholder="Search your websites...">
                        </div>
                        <a href="{{ route('website.add.url') }}" class="add-website-btn">
                            <i class="fas fa-plus-circle"></i>
                            Add New Website
                        </a>
                    </div>
                </div>

                <!-- Websites Grid -->
                @if ($result->isNotEmpty())
                    <div class="websites-grid">
                        @foreach ($result as $index => $item)
                            <div class="website-card">
                                <div class="website-header">
                                    <div class="website-logo">
                                        @if ($item->logo)
                                            <img src="{{ $item->logo }}" alt="{{ $item->title }}">
                                        @else
                                            <div class="logo-placeholder">
                                                <i class="fas fa-globe"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="website-info">
                                        <h3 class="website-title">{{ $item->title }}</h3>
                                        <a href="{{ $item->url }}" target="_blank" class="website-url">
                                            {{ $item->url }}
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="website-stats">
                                    <div class="status-info">
                                        <i class="fas fa-signal"></i>
                                        <span class="status-badge {{ $item->status === 'up' ? 'up' : 'down' }}">
                                            <i
                                                class="fas fa-{{ $item->status === 'up' ? 'check-circle' : 'times-circle' }}"></i>
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <div class="version-info">
                                        <i class="fas fa-code-branch"></i>
                                        <span class="version-badge">
                                            <i class="fab fa-php"></i>
                                            PHP {{ $item->php_version ?? '8.2' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="website-actions">
                                    <a href="{{ route('website.sso.login', ['id' => $item->id]) }}" target="_blank"
                                        class="action-btn btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login
                                    </a>
                                    <button class="action-btn btn-settings editBtn" data-id="{{ $item->id }}"
                                        data-url="{{ $item->url }}" data-username="{{ $item->username }}"
                                        data-password="{{ $item->password }}"
                                        data-decrypted-password="{{ $item->decrypted_password }}">
                                        <i class="fas fa-cog"></i>
                                        Settings
                                    </button>
                                    <a href="{{ url('admin/list-websites-' . $item->id) }}"
                                        class="action-btn btn-view">
                                        <i class="fas fa-eye"></i>
                                        View Details
                                    </a>
                                    <button class="action-btn btn-delete deleteBtn" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-globe"></i>
                        <h3>No websites found</h3>
                        <p class="text-muted mb-4">Start by adding your first website to get started with monitoring
                            and management.</p>
                        <a href="{{ route('website.add.url') }}" class="add-website-btn">
                            <i class="fas fa-plus-circle"></i>
                            Add Your First Website
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="editForm">
                @csrf
                <input type="hidden" id="editId" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-cog me-2"></i>
                            Edit Website Credentials
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editUrl" class="form-label fw-semibold">Website URL</label>
                            <input type="url" class="form-control" id="editUrl" name="url" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUsername" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label fw-semibold">Password</label>
                            <input type="text" class="form-control" id="editPassword" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            // Search functionality with smooth animation
            $('#websiteSearch').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();
                $('.website-card').each(function() {
                    const cardText = $(this).text().toLowerCase();
                    const card = $(this);

                    if (cardText.indexOf(searchValue) > -1) {
                        card.show().css('animation', 'fadeInUp 0.3s ease-out');
                    } else {
                        card.hide();
                    }
                });
            });

            // Edit modal functionality
            $('.editBtn').click(function() {
                $('#editId').val($(this).data('id'));
                $('#editUrl').val($(this).data('url'));
                $('#editUsername').val($(this).data('username'));
                $('#editPassword').val($(this).data('decryptedPassword'));

                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });

            // Submit edit form with AJAX
            $('#editForm').submit(function(e) {
                e.preventDefault();
                const id = $('#editId').val();
                const formData = $(this).serialize();
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                // Show loading state
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: '/admin/website/update/' + id,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Update the card with new data
                            const card = $('button.editBtn[data-id="' + id + '"]').closest(
                                '.website-card');
                            card.find('.website-url').attr('href', response.website.url).text(
                                response.website.url);

                            // Update data attributes
                            $('button.editBtn[data-id="' + id + '"]').attr({
                                'data-url': response.website.url,
                                'data-username': response.website.username,
                                'data-decrypted-password': response.website.password
                            });

                            // Close modal and show success
                            const editModal = bootstrap.Modal.getInstance(document
                                .getElementById('editModal'));
                            editModal.hide();

                            showNotification('success', 'Website updated successfully!');
                        } else {
                            showNotification('error', 'Failed to update website!');
                        }
                    },
                    error: function() {
                        showNotification('error', 'An error occurred while updating!');
                    },
                    complete: function() {
                        // Restore button state
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            // Delete with modern confirmation
            $('.deleteBtn').click(function() {
                const id = $(this).data('id');
                const card = $(this).closest('.website-card');
                const websiteName = card.find('.website-title').text();

                if (confirm(
                        `Are you sure you want to delete "${websiteName}"?\n\nThis action cannot be undone.`
                    )) {
                    const deleteBtn = $(this);
                    const originalText = deleteBtn.html();

                    // Show loading state
                    deleteBtn.html('<i class="fas fa-spinner fa-spin"></i> Deleting...');
                    deleteBtn.prop('disabled', true);

                    $.ajax({
                        url: '/admin/website/delete/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Animate card removal
                                card.css('animation', 'fadeOut 0.3s ease-out');
                                setTimeout(() => {
                                    card.remove();

                                    // Check if no cards remain
                                    if ($('.website-card').length === 0) {
                                        location.reload();
                                    }
                                }, 300);

                                showNotification('success', 'Website deleted successfully!');
                            } else {
                                showNotification('error', 'Failed to delete website!');
                                deleteBtn.html(originalText);
                                deleteBtn.prop('disabled', false);
                            }
                        },
                        error: function() {
                            showNotification('error', 'An error occurred while deleting!');
                            deleteBtn.html(originalText);
                            deleteBtn.prop('disabled', false);
                        }
                    });
                }
            });

            // Modern notification system
            function showNotification(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

                const notification = $(`
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);"
                     role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);

                $('body').append(notification);

                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    notification.alert('close');
                }, 5000);
            }

            // Add fade out animation for alerts
            $(document).on('closed.bs.alert', '.alert', function() {
                $(this).css('animation', 'fadeOut 0.3s ease-out');
            });

            // Copy to clipboard utility
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    showNotification('success', 'Copied to clipboard!');
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                    showNotification('error', 'Failed to copy to clipboard!');
                });
            }

            // Add fade out keyframe for animations
            const fadeOutCSS = `
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-20px); }
            }
        `;
            $('<style>').text(fadeOutCSS).appendTo('head');

            // Header interactions
            $('.user-info').hover(
                function() {
                    $(this).find('.user-menu-btn i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
                },
                function() {
                    setTimeout(() => {
                        if (!$('.user-dropdown:hover').length) {
                            $(this).find('.user-menu-btn i').addClass('fa-chevron-down').removeClass(
                                'fa-chevron-up');
                        }
                    }, 100);
                }
            );

            $('.user-dropdown').hover(
                function() {
                    // Keep dropdown open
                },
                function() {
                    $('.user-menu-btn i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
                }
            );

            // Deepak Code
            $('.user-menu-btn').click(function(e) {
                e.stopPropagation(); // prevent closing immediately
                $(this).closest('.user-profile').find('.user-dropdown').toggleClass('show');
            });
            $(document).click(function() {
                $('.user-dropdown').removeClass('show');
            });

            // Notification button click
            $('.notification-btn').click(function() {
                $(this).find('.notification-badge').fadeOut(200);
                showNotification('info', 'No new notifications');
            });

            // Active nav link highlighting
            $('.nav-link').click(function(e) {
                e.preventDefault();
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // Header scroll effect
            $(window).scroll(function() {
                const scrollTop = $(window).scrollTop();
                if (scrollTop > 20) {
                    $('.main-header').addClass('scrolled');
                } else {
                    $('.main-header').removeClass('scrolled');
                }
            });

            // Add scrolled header style
            const scrolledHeaderCSS = `
            .main-header.scrolled {
                background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.98) 0%,
                    rgba(255, 255, 255, 0.95) 50%,
                    rgba(248, 250, 252, 0.98) 100%);
                box-shadow:
                    0 15px 50px rgba(102, 126, 234, 0.15),
                    0 8px 30px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
            }
        `;
            $('<style>').text(scrolledHeaderCSS).appendTo('head');
        });
    </script>

</body>

</html>
