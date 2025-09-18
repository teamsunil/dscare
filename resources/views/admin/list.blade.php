@extends('admin.layouts.app')
@section('content')
  <div class="header-advance-area mg-t-30">
 <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list single-page-breadcome">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="breadcome-heading">
                                            <form role="search" class="sr-input-func">
                                                <input type="text" placeholder="Search..." class="search-int form-control">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="{{route('index')}}">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Website List</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  </div>

        <div class="product-status mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Website List</h4>
                            <div class="add-product">
                                <a href="{{ route('website.add.url') }}">Add Website</a>
                            </div>
                            <div class="asset-inner">
                                <table>
                                    <tr>
                                        
                                        <th>Image</th>
                                        <th>Website Url</th>
                                        <th>Website Status</th>
                                        
                                        <th>PHP Version</th>
                                        <th>Login</th>
                                        <th>Action</th>
                                    </tr>
                                    @if ($result->isNotEmpty())
                                       @foreach ($result as $index => $item)
                                            <tr>
                                                <td>
                                                    @if($item->pagespeed_screenshot !="")
                                                    <a href="{{ $item->pagespeed_screenshot }}" class="fancybox" data-fancybox="gallery{{ $index }}">
                                                        <img src="{{ $item->pagespeed_screenshot }}" width="100px" style="cursor:pointer;" />
                                                    </a>
                                                    @else
                                                    <a href="{{ asset('admin/img/product/book-2.jpg') }}" class="fancybox" data-fancybox="gallery{{ $index }}">
                                                        <img src="{{ asset('admin/img/product/book-2.jpg') }}" width="100px" />
                                                     </a>
                                                    @endif
                                                </td>
                                                <td><span>{{$item->title}}</span><br><a href="{{$item->url}}" target="_blank">{{$item->url}}</a></td>
                                               
                                                <td>{{ ucfirst($item->status) }}</td>
                                                <td>  PHP {{ $item->php_version ?? '8.2' }}</td>
                                                <td><a href="{{ route('website.sso.login', ['id' => $item->id]) }}" target="_blank"><button class="btn btn-primary btn-sm">Login</button></a></td>
                                                <td>
                                                    <button data-toggle="tooltip" title="Edit" class="pd-setting-ed  " ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    <button data-toggle="tooltip" title="Trash" class="pd-setting-ed deleteBtn"  data-id="{{ $item->id }}" data-name="{{ $item->url }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                                                   <a href="{{ url('admin/list-websites-' . $item->id) }}"><button  data-toggle="tooltip" title="View" class="pd-setting-ed"><i class="fa fa-eye"></i></button></a> 
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                 
                                </table>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>


       
@stop

@section('custom_js')
    <!-- Fancybox JS -->

  
   <script>
    $(document).ready(function () {
        $('.deleteBtn').click(function () {
            var id = $(this).data('id');
            var websiteName = $(this).data('name'); // Ensure data-name is present on button
            var deleteBtn = $(this);
            var originalText = deleteBtn.html();
            var card = deleteBtn.closest('.website-card');

            var confirmed = confirm('Are you sure you want to delete "' + websiteName + '"?\n\nThis action cannot be undone.');

            if (confirmed) {
                // Show loading state
                deleteBtn.html('<i class="fas fa-spinner fa-spin"></i> Deleting...');
                deleteBtn.prop('disabled', true);

                $.ajax({
                    url: '/admin/website/delete/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            // Animate card removal
                            card.css('animation', 'fadeOut 0.3s ease-out');

                            setTimeout(function () {
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
                    error: function () {
                        showNotification('error', 'An error occurred while deleting!');
                        deleteBtn.html(originalText);
                        deleteBtn.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>

@stop

