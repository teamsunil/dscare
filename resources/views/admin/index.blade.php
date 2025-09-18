@extends('admin.layouts.app')

@section('content')
<style>
    :root {
        --primary: #4e73df;
        --secondary: #36b9cc;
        --success: #1cc88a;
        --danger: #e74a3b;
        --text-dark: #2d3748;
        --text-light: #6c757d;
        --card-bg: #fff;
        --card-radius: 14px;
        --shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }

    body, html {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f4f7fb;
        color: var(--text-dark);
    }

    .ds-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 18px;
    }

    /* Dashboard Row */
    .ds-row {
        display: flex;
        flex-wrap: wrap;
        gap: 22px;
        margin-bottom: 28px;
    }

    /* Card Base */
    .ds-card {
        background: var(--card-bg);
        border-radius: var(--card-radius);
        box-shadow: var(--shadow);
        padding: 22px 20px;
        flex: 1 1 0;
        min-width: 0;
        transition: all 0.2s ease;
    }
    .ds-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    /* Stats Cards */
    .ds-value {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .ds-label {
        font-size: 0.95rem;
        color: var(--text-light);
    }
    .ds-icon {
        font-size: 1.8rem;
        margin-bottom: 6px;
    }

    /* Lists */
    .ds-list-card {
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }
    .ds-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 12px;
        border-bottom: 2px solid #f1f3f8;
        padding-bottom: 6px;
    }
    .ds-list-scroll {
        max-height: 330px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .ds-list-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .ds-list-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }

    /* List Item */
    .ds-list-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 8px;
        border-bottom: 1px solid #edf2f7;
        transition: background 0.15s;
    }
    .ds-list-item:hover {
        background: #f8fafc;
    }
    .ds-list-title {
        font-weight: 600;
        margin-bottom: 2px;
    }
    .ds-list-meta {
        font-size: 0.87rem;
        color: var(--text-light);
        margin-bottom: 2px;
    }

    /* Images */
    .ds-list-img, .wp-fallback-logo {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .wp-fallback-logo {
        background: #f8f9fc url('https://s.w.org/style/images/about/WordPress-logotype-wmark.png') center/65% no-repeat;
        border: 1px solid #e2e8f0;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .ds-row { flex-direction: column; }
        .ds-list-scroll { max-height: 220px; }
    }
</style>

<div class="ds-container">
    <!-- Stats -->
    <div class="ds-row">
        <div class="ds-card" style="text-align:center">
            <div class="ds-icon" style="color:var(--primary)"><i class="fa fa-globe"></i></div>
            <div class="ds-value">{{ $totalSites }}</div>
            <div class="ds-label">Total Sites</div>
        </div>
        <div class="ds-card" style="text-align:center">
            <div class="ds-icon" style="color:var(--secondary)"><i class="fa fa-rocket"></i></div>
            <div class="ds-value">{{ $activeSites }}</div>
            <div class="ds-label">Active Sites</div>
        </div>
        <div class="ds-card" style="text-align:center">
            <div class="ds-icon" style="color:var(--success)"><i class="fa fa-arrow-up"></i></div>
            <div class="ds-value">{{ $upSites }}</div>
            <div class="ds-label">Up Sites</div>
        </div>
        <div class="ds-card" style="text-align:center">
            <div class="ds-icon" style="color:var(--danger)"><i class="fa fa-arrow-down"></i></div>
            <div class="ds-value">{{ $totalSites - $upSites }}</div>
            <div class="ds-label">Down Sites</div>
        </div>
    </div>

    <!-- Website, Plugins, Themes -->
    <div class="ds-row">
        <div class="ds-card ds-list-card" style="flex:1 1 280px;max-width:340px;">
            <div class="ds-title">Website List</div>
            <div class="ds-list-scroll">
                @forelse ($websitelist as $site)
                    <div class="ds-list-item">
                        <div style="flex:1;">
                            <div class="ds-list-title">{{ $site['site_name'] }}</div>
                            <div class="ds-list-meta"><a href="{{ $site['url'] }}" target="_blank">{{ $site['url'] }}</a></div>
                            <div class="ds-list-meta">WP Version: {{ $site['wordpress_version'] }}</div>
                            @if(!empty($site['wordpress_update_available']) && $site['wordpress_update_available'] != $site['wordpress_version'])
                                <div class="ds-list-meta" style="color:var(--danger)">Update Available: {{ $site['wordpress_update_available'] }}</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="ds-label">No websites found.</p>
                @endforelse
            </div>
        </div>

        <div class="ds-card ds-list-card" style="flex:2 1 320px;max-width:400px;">
            <div class="ds-title">All Plugins</div>
            <div class="ds-list-scroll">
                @forelse ($pluginsList as $plugin)
                    <div class="ds-list-item">
                        <img src="{{ $plugin['icon_url'] ?? asset('images/wp-default-icon.png') }}" alt="{{ $plugin['name'] }}" class="ds-list-img" loading="lazy">
                        <div>
                            <div class="ds-list-title">{{ $plugin['name'] }}</div>
                            <div class="ds-list-meta">Version: {{ $plugin['version'] }} | Author: {{ $plugin['author'] }}</div>
                            <a href="{{ $plugin['plugin_uri'] }}" target="_blank">More Info</a><br>
                            <span class="ds-list-meta">Used in: {{ implode(', ', $plugin['sites']) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="ds-label">No plugins found.</p>
                @endforelse
            </div>
        </div>

        <div class="ds-card ds-list-card" style="flex:2 1 320px;max-width:400px;">
            <div class="ds-title">All Themes</div>
            <div class="ds-list-scroll">
                @forelse ($themesList as $themes)
                    <div class="ds-list-item">
                        <img src="{{ $themes['screenshot'] ?? asset('images/wp-default-icon.png') }}" alt="{{ $themes['name'] }}" class="ds-list-img" loading="lazy">
                        <div>
                            <div class="ds-list-title">{{ $themes['name'] }}</div>
                            <div class="ds-list-meta">Version: {{ $themes['version'] }} | Author: {{ $themes['author'] }}</div>
                            <a href="{{ $themes['theme_uri'] }}" target="_blank">More Info</a><br>
                            <span class="ds-list-meta">Used in: {{ implode(', ', $themes['sites']) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="ds-label">No themes found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>



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
