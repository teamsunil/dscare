<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD

=======
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Websites Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<<<<<<< HEAD
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
=======
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            color: #2c3e50;
            overflow-x: hidden;
            padding-top: 80px;
        }
        
        /* ================================
           BEAUTIFUL HEADER STYLES
        ================================ */
        
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            z-index: 1000;
            backdrop-filter: blur(25px) saturate(180%);
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.95) 0%, 
                rgba(255, 255, 255, 0.90) 50%,
                rgba(248, 250, 252, 0.95) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 10px 40px rgba(102, 126, 234, 0.1),
                0 4px 20px rgba(0, 0, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .header-blur-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(102, 126, 234, 0.05) 0%, 
                rgba(240, 147, 251, 0.05) 50%,
                rgba(76, 205, 196, 0.05) 100%);
            backdrop-filter: blur(20px);
        }
        
        .header-content {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: relative;
            z-index: 10;
        }
        
        /* Logo Section */
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, 
                #667eea 0%, 
                #764ba2 25%,
                #f093fb 50%,
                #f5576c 75%,
                #4ecdc4 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 
                0 8px 25px rgba(102, 126, 234, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            animation: logoGlow 4s ease-in-out infinite;
        }
        
        .logo-text h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
        
        .logo-text span {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Navigation */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(15px);
            padding: 0.5rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.2rem;
            border-radius: 15px;
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(102, 126, 234, 0.1) 50%, 
                transparent 100%);
            transition: left 0.5s ease;
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.08);
            transform: translateY(-1px);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, 
                rgba(102, 126, 234, 0.15) 0%, 
                rgba(240, 147, 251, 0.15) 100%);
            color: #667eea;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }
        
        .nav-link i {
            font-size: 1rem;
        }
        
        /* User Profile Section */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
        }
        
        .notifications {
            position: relative;
        }
        
        .notification-btn {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .notification-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.2);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(255, 65, 108, 0.4);
            animation: pulse 2s infinite;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            padding: 0.5rem 1rem 0.5rem 0.5rem;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .user-info:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.15);
        }
        
        .user-avatar {
            position: relative;
            width: 40px;
            height: 40px;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
        }
        
        .status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            border: 2px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 176, 155, 0.4);
        }
        
        .user-details {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
            line-height: 1.2;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }
        
        .user-menu-btn {
            background: none;
            border: none;
            color: #64748b;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-menu-btn:hover {
            color: #667eea;
            transform: rotate(180deg);
        }
        
        /* User Dropdown */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 16px;
            padding: 0.5rem;
            min-width: 200px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 25px rgba(102, 126, 234, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .user-info:hover + .user-dropdown,
        .user-dropdown:hover {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.08);
            color: #667eea;
            transform: translateX(3px);
        }
        
        .dropdown-item.logout:hover {
            background: rgba(255, 65, 108, 0.08);
            color: #ff416c;
        }
        
        .dropdown-divider {
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(148, 163, 184, 0.3) 50%, 
                transparent 100%);
            margin: 0.5rem 0;
        }
        
        /* Header Decorations */
        .header-decoration-1 {
            position: absolute;
            top: -30px;
            right: 20%;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        
        .header-decoration-2 {
            position: absolute;
            bottom: -20px;
            left: 30%;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(240, 147, 251, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatReverse 6s ease-in-out infinite;
        }
        
        .header-decoration-3 {
            position: absolute;
            top: -15px;
            left: 10%;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle, rgba(76, 205, 196, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse;
        }
        
        @keyframes logoGlow {
            0%, 100% { box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.3); }
            50% { box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.4); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .dashboard-container {
            min-height: 100vh;
            background: 
                radial-gradient(ellipse at top left, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at top right, rgba(240, 147, 251, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at bottom left, rgba(118, 75, 162, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, 
                    rgba(248, 250, 252, 0.95) 0%, 
                    rgba(241, 245, 249, 0.98) 25%,
                    rgba(226, 232, 240, 0.95) 50%,
                    rgba(203, 213, 225, 0.98) 75%,
                    rgba(148, 163, 184, 0.9) 100%);
            position: relative;
            overflow-x: hidden;
        }
        
        .dashboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 450px;
            background: linear-gradient(135deg, 
                #667eea 0%, 
                #764ba2 25%,
                #f093fb 50%,
                #f5576c 75%,
                #4ecdc4 100%);
            border-radius: 0 0 100px 100px;
            z-index: 1;
            box-shadow: 
                0 25px 80px rgba(102, 126, 234, 0.4),
                0 15px 40px rgba(240, 147, 251, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-container::after {
            content: '';
            position: absolute;
            top: 60px;
            right: 80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
            animation: floatReverse 8s ease-in-out infinite;
        }
        
        /* Additional decorative elements */
        .dashboard-container .floating-element-1 {
            position: absolute;
            top: 120px;
            left: 100px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            z-index: 1;
            animation: morphFloat 10s ease-in-out infinite;
        }
        
        .dashboard-container .floating-element-2 {
            position: absolute;
            top: 200px;
            right: 150px;
            width: 120px;
            height: 120px;
            background: rgba(240, 147, 251, 0.1);
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            z-index: 1;
            animation: morphFloat2 12s ease-in-out infinite reverse;
        }
        
        .dashboard-container .floating-element-3 {
            position: absolute;
            top: 80px;
            left: 60%;
            width: 80px;
            height: 80px;
            background: rgba(76, 205, 196, 0.12);
            border-radius: 40% 60% 60% 40% / 60% 30% 70% 40%;
            z-index: 1;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg) scale(1); 
                opacity: 0.7;
            }
            50% { 
                transform: translateY(-25px) rotate(10deg) scale(1.05); 
                opacity: 1;
            }
        }
        
        @keyframes floatReverse {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 0.6; 
            }
            50% { 
                transform: translateY(30px) rotate(-8deg) scale(0.95);
                opacity: 0.9;
            }
        }
        
        @keyframes morphFloat {
            0%, 100% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                transform: translateY(0px) rotate(0deg);
                opacity: 0.6;
            }
            25% {
                border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%;
                transform: translateY(-15px) rotate(5deg);
                opacity: 0.8;
            }
            50% {
                border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%;
                transform: translateY(-8px) rotate(-3deg);
                opacity: 1;
            }
            75% {
                border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
                transform: translateY(-20px) rotate(8deg);
                opacity: 0.7;
            }
        }
        
        @keyframes morphFloat2 {
            0%, 100% {
                border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
                transform: translateY(0px) rotate(0deg);
                opacity: 0.5;
            }
            33% {
                border-radius: 40% 60% 33% 67% / 68% 55% 45% 32%;
                transform: translateY(20px) rotate(-12deg);
                opacity: 0.8;
            }
            66% {
                border-radius: 74% 26% 47% 53% / 68% 46% 54% 32%;
                transform: translateY(-10px) rotate(6deg);
                opacity: 0.9;
            }
        }
        
        .content-wrapper {
            position: relative;
            z-index: 2;
            padding: 2rem 0;
        }
        
        .header-section {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.92) 100%);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 24px;
            padding: 2.2rem;
            margin-bottom: 2.5rem;
            box-shadow: 
                0 20px 60px rgba(102, 126, 234, 0.15),
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .dashboard-title {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            letter-spacing: -0.5px;
        }
        
        .dashboard-title i {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.2));
            animation: iconPulse 4s ease-in-out infinite;
        }
        
        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }
        
        .dashboard-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 1.8rem;
            opacity: 0.8;
            letter-spacing: 0.3px;
        }
        
        .search-container {
            position: relative;
            max-width: 400px;
        }
        
        .search-input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border: none;
            border-radius: 25px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            backdrop-filter: blur(15px) saturate(180%);
            box-shadow: 
                0 8px 32px rgba(102, 126, 234, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 
                0 12px 40px rgba(102, 126, 234, 0.25),
                0 0 0 3px rgba(102, 126, 234, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 1);
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }
        
        .search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.1rem;
            filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.3));
        }
        
        .add-website-btn {
            background: linear-gradient(135deg, 
                #667eea 0%, 
                #764ba2 25%,
                #f093fb 50%,
                #f5576c 75%,
                #4ecdc4 100%);
            border: none;
            padding: 1.2rem 2.5rem;
            border-radius: 30px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            box-shadow: 
                0 12px 40px rgba(102, 126, 234, 0.3),
                0 4px 20px rgba(240, 147, 251, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
        }
        
        .add-website-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.3) 50%, 
                transparent 100%);
            transition: left 0.6s ease;
        }
        
        .add-website-btn:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 
                0 20px 60px rgba(102, 126, 234, 0.4),
                0 8px 30px rgba(240, 147, 251, 0.3),
                0 4px 20px rgba(245, 87, 108, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            color: white;
        }
        
        .add-website-btn:hover::before {
            left: 100%;
        }
        
        .add-website-btn:active {
            transform: translateY(-2px) scale(1.02);
        }
        
        .websites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .website-card {
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.98) 0%, 
                rgba(255, 255, 255, 0.95) 50%,
                rgba(248, 250, 252, 0.98) 100%);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 28px;
            padding: 2.5rem;
            box-shadow: 
                0 20px 60px rgba(102, 126, 234, 0.08),
                0 8px 32px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .website-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, 
                #667eea 0%, 
                #764ba2 25%,
                #f093fb 50%,
                #f5576c 75%,
                #4ecdc4 100%);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 28px 28px 0 0;
        }
        
        .website-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.03) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }
        
        .website-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 
                0 32px 80px rgba(102, 126, 234, 0.15),
                0 20px 60px rgba(240, 147, 251, 0.1),
                0 12px 40px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 1);
        }
        
        .website-card:hover::before {
            transform: scaleX(1);
        }
        
        .website-card:hover::after {
            opacity: 1;
        }
        
        .website-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .website-logo {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }
        
        .website-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .logo-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .website-info {
            flex: 1;
            min-width: 0;
        }
        
        .website-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .website-url {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s ease;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .website-url:hover {
            color: #667eea;
        }
        
        .website-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }
        
        .status-info, .version-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .status-badge.up {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 50%, #4ecdc4 100%);
            color: white;
            box-shadow: 
                0 4px 15px rgba(0, 176, 155, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .status-badge.down {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 50%, #f5576c 100%);
            color: white;
            box-shadow: 
                0 4px 15px rgba(255, 65, 108, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .version-badge {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 50%, #667eea 100%);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 
                0 4px 15px rgba(78, 84, 200, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .website-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        
        .action-btn {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 50%, #4ecdc4 100%);
            color: white;
            box-shadow: 
                0 6px 20px rgba(0, 176, 155, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #00a085 0%, #85b32d 50%, #3db8b0 100%);
            box-shadow: 
                0 8px 25px rgba(0, 176, 155, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .btn-settings {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            box-shadow: 
                0 6px 20px rgba(102, 126, 234, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .btn-settings:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 50%, #e085f0 100%);
            box-shadow: 
                0 8px 25px rgba(102, 126, 234, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .btn-view {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 50%, #667eea 100%);
            color: white;
            box-shadow: 
                0 6px 20px rgba(78, 84, 200, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .btn-view:hover {
            background: linear-gradient(135deg, #4449b6 0%, #7d82e9 50%, #5a6fd8 100%);
            box-shadow: 
                0 8px 25px rgba(78, 84, 200, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 50%, #f5576c 100%);
            color: white;
            box-shadow: 
                0 6px 20px rgba(255, 65, 108, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #e53a60 0%, #e5421f 50%, #db4d60 100%);
            box-shadow: 
                0 8px 25px rgba(255, 65, 108, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .empty-state i {
            font-size: 4rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }
        
        .alert {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: none;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        
        .alert-success {
            border-left: 4px solid #00b09b;
        }
        
        .modal-content {
            border: none;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        
        .form-control {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .website-card {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .website-card:nth-child(even) {
            animation-delay: 0.1s;
        }
        
        .website-card:nth-child(3n) {
            animation-delay: 0.2s;
        }
        
        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 1.8rem;
            }
            
            .dashboard-title i {
                font-size: 1.5rem;
            }
            
            .dashboard-subtitle {
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
            }
            
            .websites-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .header-section {
                padding: 1.8rem;
                margin-bottom: 2rem;
            }
            
            .website-actions {
                grid-template-columns: 1fr;
            }
        }
</style>

<!-- Beautiful Header -->
<header class="main-header">
    <div class="header-blur-bg"></div>
    <div class="container-fluid">
        <div class="header-content">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="logo-text">
                    <h2>WebMaster</h2>
                    <span>Dashboard</span>
                </div>
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
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>
            
            <!-- User Profile Section -->
            <div class="user-profile">
                <div class="notifications">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                </div>
                
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" alt="User Avatar">
                        <div class="status-indicator"></div>
                    </div>
                    <div class="user-details">
                        <span class="user-name">John Doe</span>
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
    
    <div class="content-wrapper">
        <div class="container-fluid px-4">
            <!-- Header Section -->
            <div class="header-section">
                <h1 class="dashboard-title">
                    <i class="fas fa-globe"></i>
                    Websites Dashboard
                </h1>
                <p class="dashboard-subtitle">Manage and monitor your websites from a single, beautiful interface</p>
                
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" id="websiteSearch" placeholder="Search your websites...">
                    </div>
                    <a href="{{ route('website.add.url') }}" class="add-website-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add New Website
                    </a>
                </div>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Websites Grid -->
            @if($result->isNotEmpty())
                <div class="websites-grid">
                    @foreach ($result as $index => $item)
                        <div class="website-card">
                            <div class="website-header">
                                <div class="website-logo">
                                    @if($item->logo)
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
                                        <i class="fas fa-{{ $item->status === 'up' ? 'check-circle' : 'times-circle' }}"></i>
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
                                <a href="{{ route('website.sso.login', ['id' => $item->id]) }}" target="_blank" class="action-btn btn-login">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </a>
                                {{-- <button class="action-btn btn-settings editBtn" 
                                    data-id="{{ $item->id }}"
                                    data-username="{{ $item->username }}"
                                    data-password="{{ $item->password }}" 
                                    data-decrypted-password="{{ $item->decrypted_password }}">
                                    <i class="fas fa-cog"></i>
                                    Settings
                                </button> --}}
                                <a href="{{ url('admin/list-websites-' . $item->id) }}" class="action-btn btn-view">
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
                    <p class="text-muted mb-4">Start by adding your first website to get started with monitoring and management.</p>
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        const card = $('button.editBtn[data-id="' + id + '"]').closest('.website-card');
                        card.find('.website-url').attr('href', response.website.url).text(response.website.url);
                        
                        // Update data attributes
                        $('button.editBtn[data-id="' + id + '"]').attr({
                            'data-url': response.website.url,
                            'data-username': response.website.username,
                            'data-decrypted-password': response.website.password
                        });

                        // Close modal and show success
                        const editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
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
            
            if (confirm(`Are you sure you want to delete "${websiteName}"?\n\nThis action cannot be undone.`)) {
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
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
                     role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
<<<<<<< HEAD

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
=======
            
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
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-20px); }
            }
        `;
<<<<<<< HEAD
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
=======
        $('<style>').text(fadeOutCSS).appendTo('head');
        
        // Header interactions
        $('.user-info').hover(
            function() {
                $(this).find('.user-menu-btn i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            },
            function() {
                setTimeout(() => {
                    if (!$('.user-dropdown:hover').length) {
                        $(this).find('.user-menu-btn i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
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
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
                    0 15px 50px rgba(102, 126, 234, 0.15),
                    0 8px 30px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
            }
        `;
<<<<<<< HEAD
            $('<style>').text(scrolledHeaderCSS).appendTo('head');
        });
    </script>

</body>

=======
        $('<style>').text(scrolledHeaderCSS).appendTo('head');
    });
</script>

</body>
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
</html>
