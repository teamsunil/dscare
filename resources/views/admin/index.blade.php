@extends('admin.layouts.app')

@section('content')
<style>
    body, html { font-family: 'Segoe UI', Arial, sans-serif; background: linear-gradient(135deg, #f6f8fa 60%, #e3e9f7 100%); }
    .ds-container { max-width: 1200px; margin: 0 auto; padding: 24px 10px; }
    .ds-row { display: flex; flex-wrap: wrap; gap: 28px; margin-bottom: 28px; }
    .ds-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.09);
        padding: 22px 20px 20px 20px;
        flex: 1 1 0;
        min-width: 0;
        transition: box-shadow 0.18s, transform 0.18s;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-top: 4px solid transparent;
    }
    .ds-card:hover {
        box-shadow: 0 10px 32px rgba(0,0,0,0.16);
        transform: translateY(-3px) scale(1.015);
    }
    .ds-icon { font-size: 2.3rem; margin-bottom: 0.3rem; }
    .ds-title { font-size: 1.13rem; font-weight: 700; color: #222; margin-bottom: 0.2rem; letter-spacing: 0.01em; }
    .ds-value { font-size: 1.55rem; font-weight: 700; color: #1cc88a; margin-bottom: 0.1rem; }
    .ds-label { color: #858796; font-size: 1.01rem; margin-bottom: 0.1rem; }
    .ds-profile-box { position: relative; width: 100%; }
    .ds-profile-bg {
        border-radius: 12px;
        max-height: 90px;
        object-fit: cover;
        width: 100%;
        background: linear-gradient(90deg, #4e73df 0%, #36b9cc 100%);
    }
    .ds-profile-img {
        width: 56px; height: 56px; border-radius: 50%; object-fit: cover;
        border: 2.5px solid #4e73df; position: absolute; top: 18px; right: 18px; background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.09);
    }
    .ds-btn {
        border-radius: 22px; font-size: 1.05rem; padding: 0.45em 1.4em; background: linear-gradient(90deg,#4e73df 60%,#36b9cc 100%); color: #fff;
        border: none; cursor: pointer; margin-bottom: 10px; margin-top: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(78,115,223,0.08);
        transition: background 0.18s, box-shadow 0.18s;
    }
    .ds-btn:hover { background: linear-gradient(90deg,#375ab7 60%,#1cc88a 100%); box-shadow: 0 4px 16px rgba(54,185,204,0.13); }
    .ds-profile-content { margin-top: 0.5rem; text-align: center; width: 100%; }
    .ds-profile-stats { display: flex; justify-content: space-between; margin-top: 18px; }
    .ds-profile-stats .ds-value { font-size: 1.18rem; margin-bottom: 0; color: #4e73df; }
    .ds-profile-stats .ds-label { font-size: 0.97rem; margin-bottom: 0; color: #858796; }
    .ds-list-card { align-items: flex-start; }
    .ds-list-title { font-weight: 700; color: #343a40; margin-bottom: 1px; font-size: 1.08rem; }
    .ds-list-meta { font-size: 0.97rem; color: #6c757d; margin-bottom: 0.1rem; }
    .ds-list-img { width: 36px; height: 36px; border-radius: 7px; object-fit: cover; background: #f8f9fc; border: 1px solid #e3e6f0; margin-top: 2px; margin-right: 10px; }
    .wp-fallback-logo {
        width: 36px;
        height: 36px;
        border-radius: 7px;
        background: #f8f9fc url('https://s.w.org/style/images/about/WordPress-logotype-wmark.png') center/60% no-repeat;
        border: 1px solid #e3e6f0;
        display: inline-block;
        margin-top: 2px;
        margin-right: 10px;
    }
    .ds-list-scroll { max-height: 340px; overflow-y: auto; width: 100%; }
    .ds-list-item {
        display: flex; align-items: flex-start; border-bottom: 1px solid #f1f1f1; padding: 0.7rem 0 0.7rem 0.5rem; gap: 0.7rem;
        border-left: 4px solid #4e73df; background: #fafdff;
        transition: background 0.15s, border-color 0.15s;
    }
    .ds-list-item:nth-child(even) { background: #f6f8fa; border-left-color: #36b9cc; }
    .ds-list-item:hover { background: #e9f3ff; border-left-color: #1cc88a; }
    .ds-list-item:last-child { border-bottom: none; }
    .ds-list-item a { color: #4e73df; text-decoration: underline; font-size: 0.97rem; }
    .ds-list-item a:hover { color: #1cc88a; }
    @media (max-width: 991px) {
        .ds-row { flex-direction: column; gap: 18px; }
        .ds-list-scroll { max-height: 220px; }
    }
    @media (max-width: 767px) {
        .ds-container { padding: 10px 2px; }
        .ds-row { gap: 10px; }
        .ds-card { padding: 12px 6px; }
    }
</style>

<div class="ds-container">
    <!-- Dashboard Stats -->
    <div class="ds-row">
        <div class="ds-card">
            <div class="ds-icon" style="color:#4e73df"><i class="fa fa-globe"></i></div>
            <div class="ds-value">{{ $totalSites }}</div>
            <div class="ds-label">Total Sites</div>
        </div>
        <div class="ds-card">
            <div class="ds-icon" style="color:#36b9cc"><i class="fa fa-rocket"></i></div>
            <div class="ds-value">{{ $activeSites }}</div>
            <div class="ds-label">Active Sites</div>
        </div>
        <div class="ds-card">
            <div class="ds-icon" style="color:#1cc88a"><i class="fa fa-arrow-up"></i></div>
            <div class="ds-value">{{ $upSites }}</div>
            <div class="ds-label">Up Sites</div>
        </div>
        <div class="ds-card">
            <div class="ds-icon" style="color:#e74a3b"><i class="fa fa-arrow-down"></i></div>
            <div class="ds-value">{{ $totalSites - $upSites }}</div>
            <div class="ds-label">Down Sites</div>
        </div>
    </div>

    <!-- User Card & Plugins/Themes -->
    <div class="ds-row">
        <div class="ds-card ds-list-card" style="min-width:260px;max-width:340px;flex:1 1 260px;align-items:stretch;">
            <div class="ds-title" style="width:100%;text-align:left;margin-bottom:10px;">Website List</div>
            <div class="ds-list-scroll">
                @forelse ($websitelist as $site)
                    <div class="ds-list-item" style="border-left:4px solid #4e73df;">
                        <div style="flex:1;">
                            <div class="ds-list-title">{{ $site['site_name'] }}</div>
                            <div class="ds-list-meta"><a href="{{ $site['url'] }}" target="_blank">{{ $site['url'] }}</a></div>
                            <div class="ds-list-meta">WP Version: {{ $site['wordpress_version'] }}</div>
                            @if(!empty($site['wordpress_update_available']) && $site['wordpress_update_available'] != $site['wordpress_version'])
                                <div class="ds-list-meta" style="color:#e74a3b;">Update Available: {{ $site['wordpress_update_available'] }}</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="ds-label">No websites found.</p>
                @endforelse
            </div>
        </div>
        <div class="ds-card ds-list-card" style="min-width:260px;max-width:400px;flex:2 1 320px;align-items:stretch;">
            <div class="ds-title" style="width:100%;text-align:left;margin-bottom:10px;">All Plugins</div>
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
        <div class="ds-card ds-list-card" style="min-width:260px;max-width:400px;flex:2 1 320px;align-items:stretch;">
            <div class="ds-title" style="width:100%;text-align:left;margin-bottom:10px;">All Themes</div>
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
