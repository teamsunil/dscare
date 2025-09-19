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
                                        <li><span class="bread-blod">Add Website Credentials</span>
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
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="add-credentials-form" action="{{ route('website.submit.credentials') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Email</label>
            <input type="text" placeholder="Email" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="form-group mt-2">
            <label for="password">Password</label>
            <input type="password" placeholder="Password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <input type="hidden" placeholder="https://example.com" name="site_url" id="site_url" class="form-control" value="{{ $websiteUrl }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
                </div>
            </div>
        </div>
    </div>
    

@section('custom_js')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('add-credentials-form');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const siteUrlInput = document.getElementById('site_url');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const username = usernameInput.value;
            const password = passwordInput.value;
            const siteUrl = siteUrlInput.value.replace(/\/$/, '');
            if (!username || !password || !siteUrl) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Fields',
                    text: 'Please fill in all fields.'
                });
                return;
            }
            fetch(siteUrl + '/wp-json/laravel-sso/v1/check-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(async response => {
                const data = await response.json();
                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Credentials Added Successful',
                        text: data.message || 'Credentials are valid.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        form.submit();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Credentials Invalid',
                        text: data.message || 'Invalid credentials.'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Could not connect to the site or API.'
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
