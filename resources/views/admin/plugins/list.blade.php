@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6" style="padding-top:20px;">
                <h3 class="page-title"><i class="fa fa-plug"></i> Plugins <small class="text-muted">manage all plugins</small></h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li class="active">Plugins</li>
                </ol>
            </div>
            <div class="col-md-6 text-right">
                <div class="input-group search-inline" style="max-width:380px; margin-left:auto;">
                    <input id="pluginSearch" type="text" class="form-control input-sm" placeholder="Search plugins...">
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
                        <i class="fa fa-plug"></i> All Plugins 
                        <small class="text-muted">({{ count($pluginsList) }})</small>
                    </h4>
                    <div class="pull-right hidden-xs text-muted small" id="visibleCount">
                        Showing {{ count($pluginsList) }} of {{ count($pluginsList) }}
                    </div>
                </div>

                <div class="panel-body">
                    <div class="plugins-grid">
                        @forelse ($pluginsList as $plugin)
                            <div class="plugin-card" data-name="{{ strtolower($plugin['name']) }}" data-author="{{ strtolower($plugin['author']) }}">
                                <div class="plugin-header">
                                    <div class="plugin-icon">
                                        @if (!empty($plugin['icon_url']))
                                            <img src="{{ $plugin['icon_url'] }}" alt="{{ $plugin['name'] }}" 
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="icon-fallback" style="display: none;">
                                                {{ strtoupper(substr($plugin['name'], 0, 2)) }}
                                            </div>
                                        @else
                                            <div class="icon-fallback">
                                                {{ strtoupper(substr($plugin['name'], 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="plugin-info">
                                        <h4 class="plugin-name">{{ $plugin['name'] }}</h4>
                                        <div class="plugin-meta">
                                            <span class="version">v{{ $plugin['version'] ?: 'N/A' }}</span>
                                            @if($plugin['is_active'])
                                                <span class="status-badge active">Active</span>
                                            @endif
                                            @if(!empty($plugin['update']))
                                                <span class="status-badge update">Update Available</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="plugin-body">
                                    <div class="plugin-author">
                                        <i class="fa fa-user"></i> {{ $plugin['author'] ?: 'Unknown Author' }}
                                    </div>
                                    
                                    @if (!empty($plugin['plugin_uri']))
                                        <div class="plugin-link">
                                            <a href="{{ $plugin['plugin_uri'] }}" target="_blank" class="text-primary">
                                                <i class="fa fa-external-link"></i> More Info
                                            </a>
                                        </div>
                                    @endif

                                    <div class="plugin-usage">
                                        <button class="btn btn-info btn-sm usage-btn" 
                                                onclick="showUsageModal('{{ addslashes($plugin['name']) }}', {{ json_encode($plugin['sites']) }})">
                                            <i class="fa fa-list"></i> 
                                            Used in {{ count($plugin['sites']) }} site{{ count($plugin['sites']) != 1 ? 's' : '' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fa fa-plug"></i>
                                <h3>No plugins found</h3>
                                <p class="text-muted">No plugins are currently installed on your websites.</p>
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
                    <i class="fa fa-plug"></i> 
                    <span id="modalPluginName">Plugin Usage</span>
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
.plugins-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.plugin-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.plugin-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.plugin-header {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.plugin-icon {
    width: 50px;
    height: 50px;
    margin-right: 15px;
    flex-shrink: 0;
}

.plugin-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.icon-fallback {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    border-radius: 6px;
}

.plugin-info {
    flex: 1;
    min-width: 0;
}

.plugin-name {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.3;
}

.plugin-meta {
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

.plugin-body {
    space-y: 10px;
}

.plugin-author {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 8px;
}

.plugin-link {
    margin-bottom: 12px;
}

.plugin-link a {
    font-size: 13px;
    text-decoration: none;
}

.plugin-usage {
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
    .plugins-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .plugin-card {
        padding: 15px;
    }
}
</style>

<script>
$(function () {
    function updateVisibleCount() {
        var visible = $('.plugin-card:visible').length;
        var total = $('.plugin-card').length;
        $('#visibleCount').text('Showing ' + visible + ' of ' + total);
    }

    $('#pluginSearch').on('keyup', function () {
        var q = $.trim($(this).val()).toLowerCase();
        $('.plugin-card').each(function () {
            var name = $(this).data('name') || '';
            var author = $(this).data('author') || '';
            var match = q === '' || name.indexOf(q) !== -1 || author.indexOf(q) !== -1;
            $(this).toggle(match);
        });
        updateVisibleCount();
    });

    updateVisibleCount();
});

function showUsageModal(pluginName, sites) {
    $('#modalPluginName').text(pluginName);
    
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
        html = '<div class="text-center text-muted">No sites found using this plugin.</div>';
    }
    
    $('#sitesList').html(html);
    $('#usageModal').modal('show');
}
</script>
@stop