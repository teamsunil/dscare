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
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

    .stat-icon.primary { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
    .stat-icon.secondary { background: linear-gradient(135deg, var(--secondary), #4dd4e8); }
    .stat-icon.success { background: linear-gradient(135deg, var(--success), #2dd4aa); }
    .stat-icon.danger { background: linear-gradient(135deg, var(--danger), #f56565); }

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

    /* Modal for image preview */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
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

        .card-header {
            padding: 20px 24px 12px;
        }

        .list-item {
            padding: 16px 24px;
            gap: 12px;
        }

        .item-image, .wp-fallback {
            width: 40px;
            height: 40px;
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
        <h1><i class="fa fa-wordpress"></i> WordPress Dashboard</h1>
        <p>Manage all your WordPress sites from one place</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fa fa-globe"></i>
            </div>
            <div class="stat-value">{{ $totalSites }}</div>
            <div class="stat-label">Total Sites</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon secondary">
                <i class="fa fa-rocket"></i>
            </div>
            <div class="stat-value">{{ $activeSites }}</div>
            <div class="stat-label">Active Sites</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fa fa-arrow-up"></i>
            </div>
            <div class="stat-value">{{ $upSites }}</div>
            <div class="stat-label">Sites Online</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="fa fa-arrow-down"></i>
            </div>
            <div class="stat-value">{{ $totalSites - $upSites }}</div>
            <div class="stat-label">Sites Offline</div>
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
            </div>
            <div class="card-body">
                @forelse ($websitelist as $site)
                <div class="list-item">
                    @if(!empty($site['pagespeed_screenshot']))
                        <img src="{{ $site['pagespeed_screenshot'] }}" 
                             alt="Site Screenshot" 
                             class="item-image" 
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
                        @if(!empty($site['wordpress_version']))
                        <div class="item-meta">WP Version: {{ $site['wordpress_version'] }}</div>
                        @endif
                        @if(!empty($site['wordpress_update_available']) && $site['wordpress_update_available'] != $site['wordpress_version'])
                        <div class="item-meta update-available">Update Available: {{ $site['wordpress_update_available'] }}</div>
                        @endif
                        @if(!empty($site['website_up_down']))
                        <div class="item-meta">
                            @if(strtolower($site['website_up_down']) === 'up' || strtolower($site['website_up_down']) === 'online')
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
            </div>
            <div class="card-body">
                @forelse ($pluginsList as $plugin)
                <div class="list-item">
                    @if(!empty($plugin['icon_url']))
                        <img src="{{ $plugin['icon_url'] }}" 
                             alt="{{ $plugin['name'] }}" 
                             class="item-image"
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
                        @if(!empty($plugin['plugin_uri']))
                        <a href="{{ $plugin['plugin_uri'] }}" target="_blank" class="item-link">More Info</a>
                        @endif
                        @if(!empty($plugin['sites']))
                        <div class="item-meta">Used in: {{ is_array($plugin['sites']) ? implode(', ', $plugin['sites']) : $plugin['sites'] }}</div>
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
                    <i class="fa fa-palette"></i>
                    All Themes
                </div>
            </div>
            <div class="card-body">
                @forelse ($themesList as $theme)
                <div class="list-item">
                    @if(!empty($theme['screenshot']))
                        <img src="{{ $theme['screenshot'] }}" 
                             alt="{{ $theme['name'] }}" 
                             class="item-image"
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
                        @if(!empty($theme['theme_uri']))
                        <a href="{{ $theme['theme_uri'] }}" target="_blank" class="item-link">More Info</a>
                        @endif
                        @if(!empty($theme['sites']))
                        <div class="item-meta">Used in: {{ is_array($theme['sites']) ? implode(', ', $theme['sites']) : $theme['sites'] }}</div>
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

// Handle image loading errors and smooth scrolling
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for card bodies
    const cardBodies = document.querySelectorAll('.card-body');
    cardBodies.forEach(body => {
        body.addEventListener('wheel', function(e) {
            if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                e.preventDefault();
                this.scrollTop += e.deltaY;
            }
        }, { passive: false });
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
});
</script>




<script>
// Simple JS for smooth scroll on plugin/theme lists and WP logo fallback
// Also handles fallback for plugin/theme images to WordPress logo

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ds-list-scroll').forEach(function(list) {
        list.addEventListener('wheel', function(e) {
            if (e.deltaY !== 0) {
                e.preventDefault();
                list.scrollTop += e.deltaY;
            }
        }, { passive: false });
    });
    // Fallback for plugin/theme images to WordPress logo
    document.querySelectorAll('.ds-list-img').forEach(function(img) {
        img.onerror = function() {
            if (!this.classList.contains('wp-fallback-logo')) {
                var logo = document.createElement('div');
                logo.className = 'wp-fallback-logo';
                this.replaceWith(logo);
            }
        };
    });
});
</script>
@endsection
