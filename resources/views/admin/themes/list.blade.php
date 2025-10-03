@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title"><i class="fa fa-palette"></i> Themes <small class="text-muted">manage all themes</small></h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li class="active">Themes</li>
                </ol>
            </div>
            <div class="col-md-6 text-right">
                <div class="input-group search-inline" style="max-width:380px; margin-left:auto;">
                    <input id="themeSearch" type="text" class="form-control input-sm" placeholder="Search themes...">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="button" style="padding:5px 10px;"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default admin-panel">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top:6px;">
                        <i class="fa fa-palette"></i> All Themes 
                        <small class="text-muted">({{ count($themesList) }})</small>
                    </h4>
                    <div class="pull-right hidden-xs text-muted small" id="visibleCount">
                        Showing {{ count($themesList) }} of {{ count($themesList) }}
                    </div>
                </div>

                <div class="panel-body">
                    <div class="themes-grid">
                        @forelse ($themesList as $theme)
                            <div class="theme-card" data-name="{{ strtolower($theme['name']) }}" data-author="{{ strtolower($theme['author']) }}">
                                <div class="theme-header">
                                    <div class="theme-screenshot">
                                        @if (!empty($theme['screenshot']))
                                            <img src="{{ $theme['screenshot'] }}" alt="{{ $theme['name'] }}" 
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="screenshot-fallback" style="display: none;">
                                                {{ strtoupper(substr($theme['name'], 0, 2)) }}
                                            </div>
                                        @else
                                            <div class="screenshot-fallback">
                                                {{ strtoupper(substr($theme['name'], 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="theme-body">
                                    <div class="theme-info">
                                        <h4 class="theme-name">{{ $theme['name'] }}</h4>
                                        <div class="theme-meta">
                                            <span class="version">v{{ $theme['version'] ?: 'N/A' }}</span>
                                            @if($theme['is_active'])
                                                <span class="status-badge active">Active</span>
                                            @endif
                                            @if(!empty($theme['update']))
                                                <span class="status-badge update">Update Available</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="theme-author">
                                        <i class="fa fa-user"></i> {{ $theme['author'] ?: 'Unknown Author' }}
                                    </div>
                                    
                                    @if (!empty($theme['theme_uri']))
                                        <div class="theme-link">
                                            <a href="{{ $theme['theme_uri'] }}" target="_blank" class="text-primary">
                                                <i class="fa fa-external-link"></i> More Info
                                            </a>
                                        </div>
                                    @endif

                                    <div class="theme-usage">
                                        <button class="btn btn-info btn-sm usage-btn" 
                                                onclick="showUsageModal('{{ addslashes($theme['name']) }}', {{ json_encode($theme['sites']) }})">
                                            <i class="fa fa-list"></i> 
                                            Used in {{ count($theme['sites']) }} site{{ count($theme['sites']) != 1 ? 's' : '' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fa fa-palette"></i>
                                <h3>No themes found</h3>
                                <p class="text-muted">No themes are currently installed on your websites.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Usage Modal -->
<div id="usageModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-palette"></i> 
                    <span id="modalThemeName">Theme Usage</span>
                </h4>
            </div>
            <div class="modal-body">
                <div id="sitesList"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_js')
<style>
.themes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.theme-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.theme-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.theme-header {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.theme-screenshot {
    width: 100%;
    height: 100%;
}

.theme-screenshot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.screenshot-fallback {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 24px;
}

.theme-body {
    padding: 20px;
}

.theme-info {
    margin-bottom: 15px;
}

.theme-name {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.3;
}

.theme-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.version {
    color: #6c757d;
    font-size: 13px;
}

.status-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.update {
    background: #fff3cd;
    color: #856404;
}

.theme-author {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 8px;
}

.theme-link {
    margin-bottom: 12px;
}

.theme-link a {
    font-size: 13px;
    text-decoration: none;
}

.theme-usage {
    margin-top: 15px;
}

.usage-btn {
    width: 100%;
    border-radius: 6px;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    margin-bottom: 10px;
    color: #495057;
}

.site-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    margin-bottom: 8px;
    background: #f8f9fa;
}

.site-item:last-child {
    margin-bottom: 0;
}

.site-item i {
    margin-right: 10px;
    color: #6c757d;
}

.site-name {
    font-weight: 500;
    color: #2c3e50;
}

.site-url {
    color: #6c757d;
    font-size: 13px;
    margin-left: auto;
}

@media (max-width: 768px) {
    .themes-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .theme-card {
        margin-bottom: 0;
    }
}
</style>

<script>
$(function () {
    function updateVisibleCount() {
        var visible = $('.theme-card:visible').length;
        var total = $('.theme-card').length;
        $('#visibleCount').text('Showing ' + visible + ' of ' + total);
    }

    $('#themeSearch').on('keyup', function () {
        var q = $.trim($(this).val()).toLowerCase();
        $('.theme-card').each(function () {
            var name = $(this).data('name') || '';
            var author = $(this).data('author') || '';
            var match = q === '' || name.indexOf(q) !== -1 || author.indexOf(q) !== -1;
            $(this).toggle(match);
        });
        updateVisibleCount();
    });

    updateVisibleCount();
});

function showUsageModal(themeName, sites) {
    $('#modalThemeName').text(themeName);
    
    var html = '';
    if (sites && sites.length > 0) {
        sites.forEach(function(site) {
            html += '<div class="site-item">';
            html += '<i class="fa fa-globe"></i>';
            html += '<div>';
            html += '<div class="site-name">' + (site.name || 'Untitled Site') + '</div>';
            html += '</div>';
            html += '<div class="site-url">' + site.url + '</div>';
            html += '</div>';
        });
    } else {
        html = '<div class="text-center text-muted">No sites found using this theme.</div>';
    }
    
    $('#sitesList').html(html);
    $('#usageModal').modal('show');
}
</script>
@stop