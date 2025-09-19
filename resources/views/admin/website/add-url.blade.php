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
                                        <form hidden role="search" class="sr-input-func">
                                            <input type="text" placeholder="Search..." class="search-int form-control">
                                            <a href="#"><i class="fa fa-search"></i></a>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu">
                                        <li><a href="{{ route('index') }}">Home</a> <span class="bread-slash">/</span>
                                        </li>
                                        <li><span class="bread-blod">Add Website Url</span>
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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="product-status-wrap">
                        <form id="add-url-form" action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="url">Website URL</label>
                                <input type="url" name="url" id="url" class="form-control"
                                    placeholder="https://example.com" value="{{ old('url') }}" required>
                            </div>
                            <div id="plugin-error" class="alert alert-danger" style="display:none;"></div>
                            <button type="submit" class="btn btn-primary mt-3">Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





@section('custom_js')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('add-url-form');
        const urlInput = document.getElementById('url');
        const errorDiv = document.getElementById('plugin-error');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            const siteUrl = urlInput.value.replace(/\/$/, '');
            if (!siteUrl) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid URL',
                    text: 'Please enter a valid URL.'
                });
                return;
            }
            fetch(siteUrl + '/wp-json/laravel-sso/v1/check-plugin', {
                method: 'GET',
                mode: 'cors',
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Plugin Detected',
                        text: 'The required plugin is active. Proceeding to next step...',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        form.submit();
                    });
                } else {
                    throw new Error('Plugin not available on this site.');
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Plugin Not Detected',
                    text: 'The required plugin is not available or the site is unreachable. Please add the plugin first.'
                });
            });
        });
    });
</script>
@endsection

@section('scripts')
    @stack('scripts')
@endsection

@stop
