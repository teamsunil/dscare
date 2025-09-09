<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ data_get($response, 'site.name', 'Website Details') }} - WebMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

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
            padding: 2rem 0;
        }

        .website-details-container {
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

        /* Header Section */
        .page-header {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.92) 100%);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow:
                0 20px 60px rgba(102, 126, 234, 0.15),
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }

        .website-logo {
            width: 120px;
            height: 120px;
            border-radius: 30px;
            margin: 0 auto 1.5rem;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
            overflow: hidden;
            position: relative;
            background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .website-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            font-size: 2.5rem;
        }

        .website-title {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .website-url {
            color: #6c757d;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .website-url:hover {
            color: #667eea;
            transform: translateY(-2px);
        }

        .status-info-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .php-badge {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(78, 84, 200, 0.3);
        }

        .php-badge img {
            height: 18px;
            filter: brightness(0) invert(1);
        }

        /* Management Cards Grid */
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .management-card {
            background: linear-gradient(145deg,
                    rgba(255, 255, 255, 0.98) 0%,
                    rgba(255, 255, 255, 0.95) 50%,
                    rgba(248, 250, 252, 0.98) 100%);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 24px;
            padding: 2rem;
            box-shadow:
                0 20px 60px rgba(102, 126, 234, 0.08),
                0 8px 32px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .management-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--card-gradient);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .management-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 32px 80px rgba(102, 126, 234, 0.12),
                0 20px 60px rgba(240, 147, 251, 0.08),
                0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .management-card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .wordpress-card {
            --card-gradient: linear-gradient(135deg, #21759b 0%, #0073aa 100%);
        }

        .wordpress-card .card-icon {
            background: linear-gradient(135deg, #21759b 0%, #0073aa 100%);
        }

        .plugins-card {
            --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .plugins-card .card-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .themes-card {
            --card-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .themes-card .card-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .users-card {
            --card-gradient: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .users-card .card-icon {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 0.8rem;
        }

        .card-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3436;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .version-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .manage-btn {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 18px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .manage-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 176, 155, 0.4);
            color: white;
        }

        .wp-admin-btn {
            background: linear-gradient(135deg, #21759b 0%, #0073aa 100%);
            box-shadow: 0 4px 15px rgba(33, 117, 155, 0.3);
        }

        .wp-admin-btn:hover {
            box-shadow: 0 8px 25px rgba(33, 117, 155, 0.4);
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.8rem 1.5rem;
            border-radius: 18px;
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .back-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            transform: translateX(-5px);
        }

        /* Floating Elements */
        .floating-element-1 {
            position: absolute;
            top: 10%;
            right: 10%;
            width: 100px;
            height: 100px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 8s ease-in-out infinite;
        }

        .floating-element-2 {
            position: absolute;
            bottom: 20%;
            left: 5%;
            width: 80px;
            height: 80px;
            background: rgba(240, 147, 251, 0.1);
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            animation: float 6s ease-in-out infinite reverse;
        }

        .table thead th {
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            font-size: 13px;
            border-bottom: 2px solid #eee;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .table td img {
            border-radius: 8px;
            background: #f8f9fa;
            padding: 4px;
        }

        .badge {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 12px;
        }

        .badge.bg-success {
            background: #28a745 !important;
        }

        .badge.bg-secondary {
            background: #6c757d !important;
        }

        .badge.bg-warning {
            background: #ffc107 !important;
            color: #000;
            font-weight: 600;
        }

        .badge.bg-info {
            background: #17a2b8 !important;
        }

        .table td a {
            color: #007bff;
            /* Bootstrap primary blue */
            font-size: 13px;
            text-decoration: none;
        }

        .table td a:hover {
            text-decoration: underline;
        }

        .fancybox__container {
            z-index: 2000 !important;
            /* higher than Bootstrap modal */
        }


        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @media (max-width: 768px) {
            .management-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .website-title {
                font-size: 1.8rem;
            }

            .management-card {
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="website-details-container">
        <!-- Floating Decorative Elements -->
        <div class="floating-element-1"></div>
        <div class="floating-element-2"></div>

        <div class="container-fluid px-4">
            <!-- Back Button -->
            <a href="{{ url()->previous() }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>

            <!-- Website Header -->
            <div class="page-header">
                <div class="website-logo">
                    @if (!empty($response['site_logo_url']))
                        <img src="{{ $response['site_logo_url'] }}" alt="Site Logo">
                    @else
                        <div class="logo-placeholder">
                            <i class="fas fa-globe"></i>
                        </div>
                    @endif
                </div>

                <h1 class="website-title">{{ data_get($response, 'site.name', 'Website') }}</h1>
                <a href="{{ $result->url }}" target="_blank" class="website-url">
                    {{ $result->url }}
                    <i class="fas fa-external-link-alt"></i>
                </a>

                <div class="status-info-bar">
                    <div class="php-badge">
                        <i class="fab fa-php"></i>
                        PHP {{ data_get($response, 'php_version', '8.2') }}
                    </div>
                </div>
            </div>

            <!-- Management Cards -->
            <div class="management-grid">
                <!-- WordPress Card -->
                <div class="management-card wordpress-card">
                    <div class="card-icon">
                        <i class="fab fa-wordpress"></i>
                    </div>
                    <h3 class="card-title">WordPress</h3>
                    <div class="card-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'wordpress_version', 'N/A') }}</span>
                            <span class="stat-label">Current Version</span>
                        </div>
                        @if (data_get($response, 'wordpress_update_available'))
                            <div class="stat-item">
                                <span class="version-badge">Update Available</span>
                            </div>
                        @endif
                    </div>
                    <a href="{{ url('website/sso-login', $result->id) }}" class="manage-btn wp-admin-btn">
                        <i class="fas fa-cog"></i>
                        WP-Admin
                    </a>
                </div>

                <!-- Plugins Card -->
                <div class="management-card plugins-card">
                    <div class="card-icon">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h3 class="card-title">Plugins</h3>
                    <div class="card-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'plugins.total', 0) }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'plugins.active', 0) }}</span>
                            <span class="stat-label">Active</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'plugins.updates', 0) }}</span>
                            <span class="stat-label">Updates</span>
                        </div>
                    </div>
                    <button type="button" class="manage-btn btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#managePluginModal" data-plugin-response = '@json(data_get($response, 'plugins', null))'
                        data-plugin-id="{{ $result->id }}">
                        <i class="fas fa-cogs"></i> Manage
                    </button>

                    {{-- <a href="{{ url('admin/manage/plugins-' . $result->id) }}" class="manage-btn">
                        <i class="fas fa-cogs"></i>
                        Manage
                    </a> --}}
                </div>

                <!-- Themes Card -->
                <div class="management-card themes-card">
                    <div class="card-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3 class="card-title">Themes</h3>
                    <div class="card-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'themes.total', 0) }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'themes.current', 1) }}</span>
                            <span class="stat-label">Active</span>
                        </div>
                    </div>
                    <button type="button" class="manage-btn btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#manageThemesModal" data-theme-response = '@json(data_get($response, 'themes', null))'
                        data-theme-id="{{ $result->id }}">
                        <i class="fas fa-brush"></i> Manage
                    </button>
                    {{-- <a href="{{ url('admin/manage/theme-' . $result->id) }}" class="manage-btn">
                        <i class="fas fa-brush"></i>
                        Manage
                    </a> --}}
                </div>

                <!-- Users Card -->
                <div class="management-card users-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="card-title">Users</h3>
                    <div class="card-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'users.total', 0) }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ data_get($response, 'users.admins', 0) }}</span>
                            <span class="stat-label">Admins</span>
                        </div>
                    </div>
                    <button type="button" class="manage-btn btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#manageUserModal" data-user-response = '@json(data_get($response, 'users', null))'
                        data-user-id="{{ $result->id }}">
                        <i class="fas fa-user-cog"></i> Manage
                    </button>
                    {{-- <a href="{{ url('admin/manage/user-' . $result->id) }}" class="manage-btn">
                        <i class="fas fa-user-cog"></i>
                        Manage
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Plugins Modal -->
    <div class="modal fade" id="managePluginModal" tabindex="-1" aria-labelledby="managePluginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 90vh;">
            <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-4">Manage Plugins</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <table class="table table-striped align-middle">
                            <thead style="position: sticky; top: 0; z-index: 2; background: #f8f9fa;">
                                <tr>
                                    <th
                                        style="width: 60px; text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Icon
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Name</th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Version
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Author</th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Active
                                    </th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Update
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="pluginTableBody">
                                <!-- Rows injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Themes Modal -->
    <div class="modal fade" id="manageThemesModal" tabindex="-1" aria-labelledby="manageThemesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 90vh;">
            <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-4">Manage Themes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <table class="table table-striped align-middle">
                            <thead style="position: sticky; top: 0; z-index: 2; background: #f8f9fa;">
                                <tr>
                                    <th
                                        style="width: 60px; text-align: left; font-size: 16px; font-weight: bold; color:#000;">
                                        Screenshot
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">Name
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">Slug
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">
                                        Version
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">
                                        Author</th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Active
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="themeTableBody">
                                <!-- Rows injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Modal -->
    <div class="modal fade" id="manageUserModal" tabindex="-1" aria-labelledby="manageUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 90vh;">
            <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-4">Manage Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <div class="d-flex justify-content-end mt-2 mb-2">
                            <input type="text" id="roleSearch" class="form-control w-25"
                                placeholder="Search by role...">
                        </div>
                        <table class="table table-striped align-middle">
                            <thead style="position: sticky; top: 0; z-index: 2; background: #f8f9fa;">
                                <tr>
                                    <th style="width: 60px; font-size: 16px; font-weight: bold; color:#000;">
                                        ID
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Name</th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">
                                        Username
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Roles</th>
                                    {{-- <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Active
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <!-- Rows injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

    <script>
        $(document).ready(function() {
            // Fancybox initialize
            Fancybox.bind("[data-fancybox='theme-gallery']", {
                Toolbar: {
                    display: [{
                            id: "zoom",
                            position: "center"
                        },
                        {
                            id: "download",
                            position: "center"
                        },
                        {
                            id: "close",
                            position: "right"
                        }
                    ]
                },
                Thumbs: false,
                infinite: false,
                compact: false, // keeps toolbar full width
                animated: true, // smooth animation
            });


            // Add smooth animations on page load
            $('.management-card').each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(30px)'
                });

                setTimeout(() => {
                    $(this).css({
                        'opacity': '1',
                        'transform': 'translateY(0)',
                        'transition': 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)'
                    });
                }, 100 * (index + 1));
            });

            // Add hover effects for manage buttons
            $('.manage-btn').hover(
                function() {
                    $(this).find('i').css('transform', 'rotate(15deg)');
                },
                function() {
                    $(this).find('i').css('transform', 'rotate(0deg)');
                }
            );

            // Add click animation for buttons
            $('.manage-btn, .back-btn').on('click', function() {
                $(this).css('transform', 'scale(0.95)');
                setTimeout(() => {
                    $(this).css('transform', '');
                }, 150);
            });

            // Animate page header on load
            $('.page-header').css({
                'opacity': '0',
                'transform': 'translateY(-20px)'
            });

            setTimeout(() => {
                $('.page-header').css({
                    'opacity': '1',
                    'transform': 'translateY(0)',
                    'transition': 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)'
                });
            }, 200);

            // Animate website logo
            $('.website-logo').hover(
                function() {
                    $(this).css('transform', 'scale(1.05) rotate(2deg)');
                },
                function() {
                    $(this).css('transform', 'scale(1) rotate(0deg)');
                }
            );

            // Add ripple effect to cards
            $('.management-card').on('mousedown', function(e) {
                const card = $(this);
                const ripple = $('<div class="ripple"></div>');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.css({
                    width: size,
                    height: size,
                    left: x,
                    top: y,
                    position: 'absolute',
                    borderRadius: '50%',
                    background: 'rgba(102, 126, 234, 0.3)',
                    transform: 'scale(0)',
                    animation: 'ripple 0.6s linear',
                    pointerEvents: 'none',
                    zIndex: 1
                });

                card.css('position', 'relative');
                card.append(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

            // Add ripple animation CSS
            const rippleCSS = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            $('<style>').text(rippleCSS).appendTo('head');

            // Add parallax effect to floating elements
            $(window).on('mousemove', function(e) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                $('.floating-element-1').css('transform', `translate(${x * 20}px, ${y * 20}px)`);
                $('.floating-element-2').css('transform', `translate(${-x * 15}px, ${-y * 15}px)`);
            });

            // Manage Plugin Model
            $('#managePluginModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var response = button.data('plugin-response');

                // Parse response safely
                var data = (typeof response === 'string' && response !== '') ? JSON.parse(response) :
                    response;

                var tbody = $('#pluginTableBody');
                tbody.empty(); // Clear old rows

                // Check if data or data.items exists
                if (!data || !data.items || data.items.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No plugin data found</strong>
                            </td>
                        </tr>
                    `);
                    return;
                }

                $.each(data.items, function(index, plugin) {

                    var row = `
                        <tr>
                            <td>
                                <img src="${plugin.icon_url}"
                                    alt="${plugin.name}"
                                    width="40" height="40"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/wp-default-icon.png') }}';">
                            </td>
                            <td>
                                <strong>${plugin.name}</strong><br>
                                ${plugin.plugin_uri ? `<a href="${plugin.plugin_uri}" target="_blank">${plugin.plugin_uri}</a>` : ''}
                            </td>
                            <td>
                                ${plugin.version} ${plugin.update ? ` <span class="text-muted">→</span> <strong>${plugin.update.new_version}</strong>` : ''}
                            </td>
                            <td>${plugin.author || '-'}</td>
                            <td>
                                ${plugin.is_active
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-secondary">Inactive</span>'}
                            </td>
                            <td>
                                ${plugin.update
                                    ? `<span class="badge bg-warning">Update to ${plugin.update.new_version}</span>`
                                    : '<span class="badge bg-info">Latest</span>'}
                            </td>
                        </tr>
                    `;

                    tbody.append(row);
                });
            });



            // Manage Theme Model
            $('#manageThemesModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var response = button.data('theme-response');

                // Parse response safely
                var data = (typeof response === 'string' && response !== '') ? JSON.parse(response) :
                    response;

                var tbody = $('#themeTableBody');
                tbody.empty(); // Clear old rows

                // Check if data or data.items exists
                if (!data || !data.items || data.items.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No theme data found</strong>
                            </td>
                        </tr>
                    `);
                    return;
                }
                const themeRoundVersion = (v, decimals = 2) => v.split('.').map(p => {
                    // Check if the part is purely numeric and longer than desired decimals
                    if (/^\d+$/.test(p) && p.length > decimals) {
                        return p.substring(0, decimals);
                    }
                    return p;
                }).join('.');
                $.each(data.items, function(index, theme) {
                    var row = `
                        <tr>
                            <td>
                                <a href="${theme.screenshot}"  data-fancybox="theme-gallery"  data-caption="${theme.name}">
                                    <img src="${theme.screenshot}"
                                        alt="${theme.name}"
                                        width="40" height="40"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/wp-default-icon.png') }}';">
                                </a>
                            </td>
                            <td>${theme.slug || '-'}</td>
                            <td>
                                <strong>${theme.name}</strong><br>
                                ${theme.theme_uri ? `<a href="${theme.theme_uri}" target="_blank">${theme.theme_uri}</a>` : ''}
                            </td>
                            <td>
                                ${themeRoundVersion(theme.version)} ${theme.update ? ` <span class="text-muted">→</span> <strong>${theme.update.new_version}</strong>` : ''}
                            </td>
                            <td>${theme.author || '-'}</td>
                            <td>
                                ${theme.is_active
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-secondary">Inactive</span>'}
                            </td>
                        </tr>
                    `;

                    tbody.append(row);
                });
            });



            // Manage User Model
            $('#manageUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var response = button.data('user-response');
                var data = (typeof response === 'string' && response !== '') ? JSON.parse(response) :
                    response;

                var tbody = $('#userTableBody');
                tbody.empty();

                if (!data || !Array.isArray(data.items) || data.items.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No user data found</strong>
                            </td>
                        </tr>
                    `);
                    return;
                }

                var allUsers = data.items;

                // Normalize roles to a sorted, comma-separated string
                function normalizeRoles(roles) {
                    if (!roles) return '';
                    // If it's an array, try to extract a name/role string from each element
                    if (Array.isArray(roles)) {
                        var arr = roles.map(function(r) {
                            if (typeof r === 'string') return r;
                            if (r && typeof r === 'object') {
                                // common property names: name, role, roleName
                                return r.name || r.role || r.roleName || '';
                            }
                            return String(r);
                        }).filter(Boolean);
                        // sort alphabetically and join with comma
                        return arr.sort(function(a, b) {
                            return a.localeCompare(b, undefined, {
                                sensitivity: 'base'
                            });
                        }).join(', ');
                    }

                    // If it's an object (like {admin: true, user: false}), join the truthy keys
                    if (typeof roles === 'object') {
                        return Object.keys(roles).filter(function(k) {
                            return roles[k];
                        }).sort().join(', ');
                    }

                    // fallback: string/number -> return as string
                    return String(roles);
                }

                function renderUsers(users) {
                    tbody.empty();
                    if (users.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <strong>No matching users found</strong>
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    users.forEach(function(user) {
                        var rolesStr = normalizeRoles(user.roles);

                        // Use jQuery element creation and .text() for roles to avoid XSS issues
                        var $tr = $('<tr>');
                        $tr.append($('<td>').html('<strong>' + (user.id || '') + '</strong>'));
                        $tr.append($('<td>').html('<strong>' + (user.name || '') + '</strong><br>' +
                            (user.email || '')));
                        $tr.append($('<td>').text(user.username || '-'));
                        $tr.append($('<td>').text(rolesStr || '-'));

                        tbody.append($tr);
                    });
                }

                // initial render
                renderUsers(allUsers);

                // Role search filter (case-insensitive)
                $('#roleSearch').off('keyup').on('keyup', function() {
                    var searchVal = $(this).val().toLowerCase().trim();
                    if (searchVal === '') {
                        renderUsers(allUsers);
                        return;
                    }

                    var filtered = allUsers.filter(function(user) {
                        var rolesStr = normalizeRoles(user.roles).toLowerCase();
                        return rolesStr.indexOf(searchVal) !== -1;
                    });

                    renderUsers(filtered);
                });
            });


        });
    </script>


</body>

</html>
