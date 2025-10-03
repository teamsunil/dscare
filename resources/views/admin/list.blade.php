@extends('admin.layouts.app')
@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="page-title"><i class="fa fa-globe"></i> Website List <small class="text-muted">manage websites</small></h3>
        </div>
        <div class="col-sm-6 text-right">
          <a href="{{ route('website.add.url') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Website</a>
        </div>
      </div>
      <div class="row mg-t-10">
        <div class="col-md-6">
          <ol class="breadcrumb">
            <li><a href="{{ route('index') }}">Home</a></li>
            <li class="active">Website List</li>
          </ol>
        </div>
        <div class="col-md-6 text-right">
          <div class="input-group search-inline" style="max-width:380px; margin-left:auto;">
            <input id="tableSearch" type="text" class="form-control input-sm" placeholder="Search title, url or status...">
            <span class="input-group-btn" >
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
            <h4 class="panel-title pull-left" style="padding-top:6px;"><i class="fa fa-table"></i> Listings <small class="text-muted">({{ $result->count() }})</small></h4>
            <div class="pull-right hidden-xs text-muted small" id="visibleCount">Showing {{ $result->count() }} of {{ $result->count() }}</div>
          </div>

          <div class="panel-body">
            <div class="table-responsive">
              <table id="websitesTable" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width:110px;">Preview</th>
                    <th>Website</th>
                    <th style="width:120px;">Website Status</th>
                     <th style="width:120px;">Plugin Status</th>
                    <th style="width:120px;">PHP</th>
                    <th style="width:90px;">Login</th>
                    <th style="width:170px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($result->isNotEmpty())
                    @foreach ($result as $index => $item)
                      <tr data-title="{{ strtolower($item->title) }}" data-url="{{ strtolower($item->url) }}" data-status="{{ strtolower($item->status) }}">
                        <td class="vcenter">
                          @if($item->pagespeed_screenshot != "")
                            <a href="{{ $item->pagespeed_screenshot }}" class="fancybox" data-fancybox="gallery{{ $index }}">
                              <img src="{{ $item->pagespeed_screenshot }}" class="img-responsive img-thumb" />
                            </a>
                          @else
                            <img src="{{ asset('admin/img/product/book-2.jpg') }}" class="img-responsive img-thumb" />
                          @endif
                        </td>

                        <td>
                          <div class="site-title"><strong>{{ $item->title }}</strong></div>
                          <div class="site-url"><a href="{{ $item->url }}" target="_blank">{{ \Illuminate\Support\Str::limit($item->url, 60) }}</a></div>
                          @if(!empty($item->notes))
                            <div class="text-muted small hidden-xs">{{ \Illuminate\Support\Str::limit($item->notes, 80) }}</div>
                          @endif
                        </td>

                        <td class="vcenter">
                          @php $s = strtolower($item->status); @endphp
                          <span class="badge status-{{ $s }}">{{ ucfirst($item->status) }}</span>
                        </td>
                         <td class="vcenter">
                          @php $website_status = strtolower($item->website_status); @endphp
                          <span class="badge status-{{ $website_status }}">{{ ucfirst($item->website_status) }}</span>
                        </td>
                      @php $data=json_decode($item->data); @endphp
                        <td class="vcenter">PHP {{ $data->php_version?? '8.2' }}</td>

                        <td class="vcenter">
                          <button type="button" class="btn btn-primary btn-xs sso-login-btn" data-id="{{ $item->id }}" data-url="{{ route('website.sso.login', ['id' => $item->id]) }}" style="margin-top: 0px;"><i class="fa fa-sign-in"></i> Login</button>
                        </td>

                        <td class="vcenter">
                          <div class="btn-group btn-group-sm table-actions" role="group" aria-label="actions">
                            {{-- <button class="btn btn-info editBtn" 
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->title }}"
                                    data-url="{{ $item->url }}"
                                    data-status="{{ $item->status }}"
                                    data-php="{{ $item->php_version }}">
                              <i class="fa fa-pencil"></i>
                            </button> --}}

                            <button class="btn btn-danger deleteBtn" data-id="{{ $item->id }}" data-name="{{ $item->url }}">
                              <i class="fa fa-trash-o"></i>
                            </button>

                            <a href="{{ url('admin/list-websites-' . $item->id) }}" class="btn btn-default" title="View" style="margin-top: 0px;"><i class="fa fa-eye"></i></a>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="6" class="text-center text-muted">No websites available</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Edit Modal (keeps edit in modal, no new edit route) -->
  <div id="editWebsiteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form id="editWebsiteForm" method="POST" action="#" role="form">
          {{ csrf_field() }}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Website</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group">
              <label for="edit_title">Title</label>
              <input type="text" name="title" id="edit_title" class="form-control input-sm">
            </div>
            <div class="form-group">
              <label for="edit_url">URL</label>
              <input type="text" name="url" id="edit_url" class="form-control input-sm">
            </div>
            <div class="form-group">
              <label for="edit_status">Status</label>
              <select name="status" id="edit_status" class="form-control input-sm">
                <option value="active">Active</option>
                <option value="maintenance">Maintenance</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="form-group">
              <label for="edit_php">PHP Version</label>
              <input type="text" name="php_version" id="edit_php" class="form-control input-sm">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@stop

@section('custom_js')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
  // ...existing code...

  // SSO Login via JS
  $(document).on('click', '.sso-login-btn', function () {
    var btn = $(this);
    var loginUrl = btn.data('url');
    window.open(loginUrl, '_blank');
  });
});
</script>
<style>
  /* Theme-aligned styles (match other admin pages) */
  .content-header { padding: 18px 0; border-bottom: 1px solid #eee; margin-bottom: 15px; }
  .page-title { margin: 0; font-weight: 600; }
  .admin-panel .panel-heading { background: #fff; border-bottom: 1px solid #eee; }
  .img-thumb { max-width:100px; max-height:60px; border:1px solid #e9e9e9; padding:2px; background:#fff; }
  .vcenter { vertical-align: middle !important; }
  .site-url a { color: #337ab7; word-break: break-all; }
  .table-actions .btn { min-width:36px; }
  .badge { padding:6px 8px; font-size:12px; }
  .status-active { background:#5cb85c; color:#fff; }
  .status-maintenance { background:#f0ad4e; color:#fff; }
  .status-inactive { background:#777; color:#fff; }
  .search-inline .form-control { height:32px; }
</style>

<script>
  $(function () {
    // client-side search with count update
    function updateVisibleCount() {
      var visible = $('#websitesTable tbody tr:visible').length;
      var total = $('#websitesTable tbody tr').length;
      $('#visibleCount').text('Showing ' + visible + ' of ' + total);
    }

    $('#tableSearch').on('keyup', function () {
      var q = $.trim($(this).val()).toLowerCase();
      $('#websitesTable tbody tr').each(function () {
        var title = $(this).data('title') || '';
        var url = $(this).data('url') || '';
        var status = $(this).data('status') || '';
        var match = q === '' || title.indexOf(q) !== -1 || url.indexOf(q) !== -1 || status.indexOf(q) !== -1;
        $(this).toggle(match);
      });
      updateVisibleCount();
    });

    // open edit modal and populate fields (no separate edit route added)
    $(document).on('click', '.editBtn', function () {
      var b = $(this);
      $('#edit_id').val(b.data('id'));
      $('#edit_title').val(b.data('title'));
      $('#edit_url').val(b.data('url'));
      $('#edit_status').val(b.data('status'));
      $('#edit_php').val(b.data('php'));
      $('#editWebsiteModal').modal('show');
    });

    // delete via existing route (AJAX)
    $(document).on('click', '.deleteBtn', function () {
      var btn = $(this);
      var id = btn.data('id');
      var name = btn.data('name');
      var row = btn.closest('tr');
      if (!confirm('Delete "' + name + '"?')) return;
      var orig = btn.html();
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
      $.ajax({
        url: '/admin/website/delete/' + id,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function (res) {
          if (res && res.success) {
            row.fadeOut(200, function () { $(this).remove(); updateVisibleCount(); });
          } else {
            alert(res.message || 'Failed to delete.');
            btn.prop('disabled', false).html(orig);
          }
        },
        error: function () {
          alert('Error while deleting.');
          btn.prop('disabled', false).html(orig);
        }
      });
    });

    // init count
    updateVisibleCount();
  });
</script>
@stop

    