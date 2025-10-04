<<<<<<< HEAD
@extends('admin.layouts.app')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4e73df;
            --primary-light: #5a7ae4;
            --secondary: #36b9cc;
            --success: #1cc88a;
            --danger: #e74a3b;
            --warning: #f6c23e;
            --info: #17a2b8;
            --text-dark: #2d3748;
            --text-light: #6c757d;
            --text-muted: #9ca3af;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --card-radius: 16px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .wp-dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
        }

        .wp-dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .wp-dashboard-header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .wp-dashboard-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        /* Stats Cards Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--bg-white);
            border-radius: var(--card-radius);
            padding: 28px;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.8rem;
            color: white;
            position: relative;
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
        }

        .stat-icon.secondary {
            background: linear-gradient(135deg, var(--secondary), #4dd4e8);
        }

        .stat-icon.success {
            background: linear-gradient(135deg, var(--success), #2dd4aa);
        }

        .stat-icon.danger {
            background: linear-gradient(135deg, var(--danger), #f56565);
        }

        .stat-icon.warning {
            background: linear-gradient(135deg, var(--warning), #ffd93d);
        }

        .stat-icon.info {
            background: linear-gradient(135deg, var(--info), #38a3c7);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .stat-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Charts Section */
        .charts-section {
            margin-bottom: 40px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }

        .chart-card {
            background: var(--bg-white);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .chart-header {
            padding: 24px 28px 16px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(90deg, var(--bg-light), var(--bg-white));
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chart-title i {
            color: var(--primary);
        }

        .chart-body {
            padding: 28px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 32px;
        }

        .content-card {
            background: var(--bg-white);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            padding: 24px 28px 16px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(90deg, var(--bg-light), var(--bg-white));
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title i {
            color: var(--primary);
        }

        .card-body {
            padding: 0;
            max-height: 480px;
            overflow-y: auto;
        }

        .card-body::-webkit-scrollbar {
            width: 6px;
        }

        .card-body::-webkit-scrollbar-track {
            background: var(--bg-light);
        }

        .card-body::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 3px;
        }

        /* List Items */
        .list-item {
            padding: 20px 28px;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s ease;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .list-item:hover {
            background: var(--bg-light);
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .item-image:hover {
            transform: scale(1.05);
        }

        .wp-fallback {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #21759b, #2e8bc0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }

        .item-content {
            flex: 1;
            min-width: 0;
        }

        .item-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .item-meta {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .item-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .item-link:hover {
            color: var(--primary-light);
        }

        .update-available {
            color: var(--danger);
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-up {
            background: rgba(28, 200, 138, 0.1);
            color: var(--success);
        }

        .status-down {
            background: rgba(231, 74, 59, 0.1);
            color: var(--danger);
        }

        .empty-state {
            padding: 40px 28px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary), #4dd4e8);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(54, 185, 204, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #2dd4aa);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(28, 200, 138, 0.3);
        }

        /* Enhanced Dropdown Styles - Slide Down Animation */
        .used-in-dropdown {
            position: relative;
            display: inline-block;
            margin-top: 6px;
        }

        .dropdown-toggle {
            background: linear-gradient(135deg, var(--info), #38a3c7);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            justify-content: space-between;
        }

        .dropdown-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
            background: linear-gradient(135deg, #38a3c7, var(--info));
        }

        .dropdown-toggle .fa-chevron-down,
        .dropdown-toggle .fa-chevron-up {
            transition: transform 0.3s ease;
            font-size: 0.7rem;
        }

        .dropdown-toggle.active .fa-chevron-down {
            transform: rotate(180deg);
        }

        .dropdown-content {
            position: relative;
            background: var(--bg-light);
            border-radius: 8px;
            margin-top: 8px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-content.show {
            max-height: 300px;
            opacity: 1;
            transform: translateY(0);
            box-shadow: var(--shadow-sm);
        }

        .dropdown-item {
            display: block;
            padding: 12px 16px;
            color: var(--text-dark);
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.2s ease;
            font-size: 0.875rem;
            position: relative;
        }

        .dropdown-item:hover {
            background: var(--bg-white);
            color: var(--primary);
            padding-left: 20px;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item i {
            margin-right: 8px;
            color: var(--text-muted);
            transition: color 0.2s ease;
            width: 16px;
            text-align: center;
        }

        .dropdown-item:hover i {
            color: var(--primary);
        }

        /* Modal for image preview */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 90%;
            max-height: 90%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .modal img {
            width: 100%;
            height: auto;
            display: block;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
        }

        .close:hover {
            opacity: 0.7;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr 1fr;
                gap: 24px;
            }
        }

        @media (max-width: 768px) {
            .wp-dashboard-container {
                padding: 16px;
            }

            .wp-dashboard-header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 16px;
            }

            .charts-grid,
            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 2rem;
            }

            .card-header,
            .chart-header {
                padding: 20px 24px 12px;
            }

            .list-item {
                padding: 16px 24px;
                gap: 12px;
            }

            .item-image,
            .wp-fallback {
                width: 40px;
                height: 40px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 16px;
            }

            .list-item {
                padding: 12px 16px;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .action-buttons {
                width: 100%;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="wp-dashboard-container">
        <div class="wp-dashboard-header">
            <h1><i class="fa fa-wordpress"></i> DS Care - WordPress Dashboard</h1>
            <p>Manage all your WordPress sites from one place</p>
        </div>

        <!-- Enhanced Stats Cards with Additional Metrics -->
        <div class="stats-grid">
            <div class="stat-card">
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <div class="stat-icon primary">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="stat-value">{{ $totalSites }}</div>
                <div class="stat-label">Total Sites</div>
                </a>
            </div>


            
            <div class="stat-card">   
                <a href="{{ url('admin/website-list').'?status=up' }}" class="text-decoration-none">
                <div class="stat-icon success">
                    <i class="fa fa-arrow-up"></i>
                </div>
                <div class="stat-value">{{ $upSites }}</div>
                <div class="stat-label">Sites Up</div>
            </a>
            </div>



            <div class="stat-card">
                  <a href="{{ url('admin/website-list').'?status=down' }}" class="text-decoration-none">
                <div class="stat-icon danger">
                    <i class="fa fa-arrow-down"></i>
                </div>
                <div class="stat-value">{{ $totalSites - $upSites }}</div>
                <div class="stat-label">Sites Down</div>
                  </a>
            </div>


            
            <div class="stat-card">
                <a href="{{ route('plugins.list') }}" class="text-decoration-none">
                <div class="stat-icon warning">
                    <i class="fa fa-plug"></i>
                </div>
                <div class="stat-value">{{ count($pluginsList) }}</div>
                <div class="stat-label">Total Plugins</div>
                </a>
            </div>

            <div class="stat-card">
                <a href="{{ route('themes.list') }}" class="text-decoration-none">
                <div class="stat-icon info">
                    <i class="fa fa-paint-brush icon-wrap sub-icon-mg" aria-hidden="true"></i>
                </div>
                <div class="stat-value">{{ count($themesList) }}</div>
                <div class="stat-label">Total Themes</div>
                </a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="charts-grid">
                <!-- Site Status Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">
                            <i class="fa fa-chart-pie"></i>
                            Site Status Distribution
                        </div>
                    </div>
                    <div class="chart-body">
                        <canvas id="siteStatusChart"></canvas>
                    </div>
                </div>

                <!-- WordPress Version Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">
                            <i class="fa fa-chart-bar"></i>
                            WP Versions
                        </div>
                    </div>
                    <div class="chart-body">
                        <canvas id="wpVersionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Websites List -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-list"></i>
                        Website List
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> View All
                    </a>
                </div>
                <div class="card-body">
                    @forelse ($websitelist as $site)
                        <div class="list-item">
                            @if (!empty($site['pagespeed_screenshot']))
                                <img src="{{ $site['pagespeed_screenshot'] }}" alt="Site Screenshot" class="item-image"
                                    onclick="showModal('{{ $site['pagespeed_screenshot'] }}')"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="wp-fallback" style="display: none;">WP</div>
                            @else
                                <div class="wp-fallback">WP</div>
                            @endif

                            <div class="item-content">
                                <div class="item-title">{{ $site['site_name'] ?: 'Untitled Site' }}</div>
                                <div class="item-meta">
                                    <a href="{{ $site['url'] }}" target="_blank" class="item-link">{{ $site['url'] }}</a>
                                </div>
                                @if (!empty($site['wordpress_version']))
                                    <div class="item-meta">WP Version: {{ $site['wordpress_version'] }}</div>
                                @endif
                                @if (!empty($site['wordpress_update_available']) && $site['wordpress_update_available'] != $site['wordpress_version'])
                                    <div class="item-meta update-available">Update Available:
                                        {{ $site['wordpress_update_available'] }}</div>
                                @endif
                                @if (!empty($site['website_up_down']))
                                    <div class="item-meta">
                                        @if (strtolower($site['website_up_down']) === 'up' || strtolower($site['website_up_down']) === 'online')
                                            <span class="status-badge status-up">
                                                <i class="fa fa-circle"></i> Online
                                            </span>
                                        @else
                                            <span class="status-badge status-down">
                                                <i class="fa fa-circle"></i> Offline
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Action Buttons for Website -->
                                <div class="action-buttons">
                                    <a href="{{ url('admin/list-websites-' . $site['id']) }}" target="_blank"
                                        class="btn btn-primary">
                                        <i class="fa fa-eye"></i> View Site
                                    </a>
                                    <a href="{{ url('website/sso-login', $site['id']) }}" target="_blank" data-id="{{ $site['id'] }}"
                                        data-url="{{ route('website.sso.login', ['id' => $site['id']]) }}" target="_blank"
                                        class="btn btn-success">
                                        <i class="fa fa-sign-in-alt"></i> Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fa fa-globe"></i>
                            <p>No websites found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Plugins List -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-plug"></i>
                        All Plugins
                    </div>
                    <a href="{{ route('plugins.list') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> View All
                    </a>
                </div>
                <div class="card-body">
                    @forelse ($pluginsList as $plugin)
                        <div class="list-item">
                            @if (!empty($plugin['icon_url']))
                                <img src="{{ $plugin['icon_url'] }}" alt="{{ $plugin['name'] }}" class="item-image"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="wp-fallback" style="display: none;">
                                    {{ strtoupper(substr($plugin['name'], 0, 2)) }}
                                </div>
                            @else
                                <div class="wp-fallback">
                                    {{ strtoupper(substr($plugin['name'], 0, 2)) }}
                                </div>
                            @endif

                            <div class="item-content">
                                <div class="item-title">{{ $plugin['name'] }}</div>
                                <div class="item-meta">
                                    Version: {{ $plugin['version'] ?? 'N/A' }} |
                                    Author: {{ $plugin['author'] ?? 'Unknown' }}
                                </div>
                                @if (!empty($plugin['plugin_uri']))
                                    <a href="{{ $plugin['plugin_uri'] }}" target="_blank" class="item-link">More Info</a>
                                @endif

                                

                                @if (!empty($plugin['sites']))
                                    <div class="used-in-dropdown">
                                        <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                            <span>
                                                <i class="fa fa-list"></i>
                                                Used in ({{ is_array($plugin['sites']) ? count($plugin['sites']) : 1 }})
                                            </span>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            @if (is_array($plugin['sites']))
                                                @foreach ($plugin['sites'] as $siteName)
                                                    <a href="#" class="dropdown-item">
                                                        <i class="fa fa-globe"></i>
                                                        {{ $siteName }}
                                                    </a>
                                                @endforeach
                                            @else
                                                <a href="#" class="dropdown-item">
                                                    <i class="fa fa-globe"></i>
                                                    {{ $plugin['sites'] }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fa fa-plug"></i>
                            <p>No plugins found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Themes List -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa fa-paint-brush"></i>
                        All Themes
                    </div>
                    <a href="{{ route('themes.list') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> View All
                    </a>
                </div>
                <div class="card-body">
                    @forelse ($themesList as $theme)
                        <div class="list-item">
                            @if (!empty($theme['screenshot']))
                                <img src="{{ $theme['screenshot'] }}" alt="{{ $theme['name'] }}" class="item-image"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="wp-fallback" style="display: none;">
                                    {{ strtoupper(substr($theme['name'], 0, 2)) }}
                                </div>
                            @else
                                <div class="wp-fallback">
                                    {{ strtoupper(substr($theme['name'], 0, 2)) }}
                                </div>
                            @endif

                            <div class="item-content">
                                <div class="item-title">{{ $theme['name'] }}</div>
                                <div class="item-meta">
                                    Version: {{ $theme['version'] ?? 'N/A' }} |
                                    Author: {{ $theme['author'] ?? 'Unknown' }}
                                </div>
                                @if (!empty($theme['theme_uri']))
                                    <a href="{{ $theme['theme_uri'] }}" target="_blank" class="item-link">More Info</a>
                                @endif

                                @if (!empty($theme['sites']))
                                    <div class="used-in-dropdown">
                                        <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                            <span>
                                                <i class="fa fa-list"></i>
                                                Used in ({{ is_array($theme['sites']) ? count($theme['sites']) : 1 }})
                                            </span>
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            @if (is_array($theme['sites']))
                                                @foreach ($theme['sites'] as $siteName)
                                                    <a href="#" class="dropdown-item">
                                                        <i class="fa fa-globe"></i>
                                                        {{ $siteName }}
                                                    </a>
                                                @endforeach
                                            @else
                                                <a href="#" class="dropdown-item">
                                                    <i class="fa fa-globe"></i>
                                                    {{ $theme['sites'] }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fa fa-palette"></i>
                            <p>No themes found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for image preview -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImg" src="" alt="Screenshot Preview">
        </div>
    </div>
    @php
        $wpVersions = [];
        foreach ($websitelist as $site) {
            if (!empty($site['wordpress_version'])) {
                $version = $site['wordpress_version'];
                if (isset($wpVersions[$version])) {
                    $wpVersions[$version]++;
                } else {
                    $wpVersions[$version] = 1;
                }
            }
        }
    @endphp
    <!-- Chart.js CDN -->
    <script>
  
        document.addEventListener("click", function (e) {
       
    if (e.target.closest(".sso-login-btn")) {
             e.preventDefault();
        const btn = e.target.closest(".sso-login-btn");
        const loginUrl = btn.getAttribute("data-url");

        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Login';

        fetch(loginUrl, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res && res.success && res.redirect_url) {
                window.open(res.redirect_url, "_blank"); // or `window.location.href = res.redirect_url;`
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: res.message || "Could not login via SSO."
                });
            }
        })
        .catch(err => {
            Swal.fire({
                icon: "error",
                title: "Login Failed",
                text: err.message || "Could not login via SSO."
            });
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-sign-in"></i> Login';
        });
    }
});
       

        function toggleDropdown(button) {
            const dropdown = button.nextElementSibling;
            const chevron = button.querySelector('.fa-chevron-down, .fa-chevron-up');

            // Close all other dropdowns
            document.querySelectorAll('.dropdown-content.show').forEach(content => {
                if (content !== dropdown) {
                    content.classList.remove('show');
                    const otherButton = content.previousElementSibling;
                    if (otherButton) {
                        otherButton.classList.remove('active');
                        const otherChevron = otherButton.querySelector('.fa-chevron-down, .fa-chevron-up');
                        if (otherChevron) {
                            otherChevron.className = 'fa fa-chevron-down';
                        }
                    }
                }
            });

            // Toggle current dropdown
            dropdown.classList.toggle('show');
            button.classList.toggle('active');
            if (chevron) {
                chevron.className = dropdown.classList.contains('show') ?
                    'fa fa-chevron-up' :
                    'fa fa-chevron-down';
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>

    <script>
        // Image modal functionality
        function showModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImg');
            modal.style.display = 'block';
            modalImg.src = src;
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Close modal when clicking outside the image
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Enhanced Dropdown functionality with smooth slide animation


        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {

            // Site Status Chart Data

            // Smooth scrolling for card bodies
            const cardBodies = document.querySelectorAll('.card-body');
            cardBodies.forEach(body => {
                body.addEventListener('wheel', function(e) {
                    if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                        e.preventDefault();
                        this.scrollTop += e.deltaY;
                    }
                }, {
                    passive: false
                });
            });

            // Add entrance animations
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.style.animation = 'slideInUp 0.6s ease-out forwards';
            });

            // Close modal with escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.used-in-dropdown')) {
                    document.querySelectorAll('.dropdown-content.show').forEach(content => {
                        content.classList.remove('show');
                        const button = content.previousElementSibling;
                        const chevron = button.querySelector('.fa-chevron-down, .fa-chevron-up');
                        button.classList.remove('active');
                        chevron.className = 'fa fa-chevron-down';
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- Site Status Chart ---
            const totalSites = {{ $totalSites }};
            const upSites = {{ $upSites }};
            const downSites = totalSites - upSites;
            const siteStatusCtx = document.getElementById('siteStatusChart');
            if (siteStatusCtx) {
                new Chart(siteStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sites Up', 'Sites Down'],
                        datasets: [{
                            data: [upSites, downSites], // example numbers
                            backgroundColor: ['#1cc88a', '#e74a3b'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // --- WP Version Chart ---
            const wpVersions = <?php echo json_encode($wpVersions); ?>;

            // Split into arrays for charting
            const versionKeys = Object.keys(wpVersions); // e.g. ['6.1','6.0','5.8']
            const versionCounts = Object.values(wpVersions);

            const wpVersionCtx = document.getElementById('wpVersionChart');
            if (wpVersionCtx) {
                new Chart(wpVersionCtx, {
                    type: 'bar',
                    data: {
                        labels: [versionKeys],
                        datasets: [{
                            label: 'Number of Sites',
                            data: [versionCounts],
                            backgroundColor: '#4e73df'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

@endsection
=======
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to the admin panel!</p>
@stop
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
