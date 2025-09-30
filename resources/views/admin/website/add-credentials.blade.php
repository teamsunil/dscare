@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row visible-xs">
        <div class="col-xs-12">
            <div class="page-header">
                <h1 class="h3">Website Credentials</h1>
            </div>
        </div>
    </div>

    <!-- Breadcrumb - Hidden on mobile -->
    <div class="row hidden-xs">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li class="active">Website Credentials</li>
            </ol>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading hidden-xs">
                    <h3 class="panel-title">Add Website Credentials</h3>
                </div>
                <div class="panel-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li><span class="glyphicon glyphicon-exclamation-sign"></span> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="add-credentials-form" action="{{ route('website.submit.credentials') }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label for="username" class="col-xs-12 col-sm-3 col-md-2 control-label">Email or Username</label>
                            <div class="col-xs-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                    <input type="text" 
                                           name="username" 
                                           id="username" 
                                           class="form-control" 
                                           placeholder="Enter your email or username"
                                           value="{{ old('username') }}" 
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-xs-12 col-sm-3 col-md-2 control-label">Password</label>
                            <div class="col-xs-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="form-control" 
                                           placeholder="Enter your password"
                                           required>
                                </div>
                            </div>
                        </div>

               <input type="hidden" 
                   name="site_url" 
                   id="site_url" 
                   value="{{ $websiteUrl }}" 
                   required>
               <input type="hidden"
                   name="shared_secret"
                   id="shared_secret"
                   value="{{ $sharedSecret ?? '' }}"
                   required>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                                <div id="credentials-error" class="alert alert-danger" style="display:none;"></div>
                                <button type="submit" class="btn btn-success btn-block-xs">
                                    <span class="glyphicon glyphicon-ok"></span> Save Credentials
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

@section('custom_js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-credentials-form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const siteUrlInput = document.getElementById('site_url');
    const errorDiv = document.getElementById('credentials-error');

    function showError(message) {
        errorDiv.innerHTML = '<span class="glyphicon glyphicon-exclamation-sign"></span> ' + message;
        errorDiv.style.display = 'block';
        errorDiv.className = 'alert alert-danger';
    }

    function showSuccess(message) {
        errorDiv.innerHTML = '<span class="glyphicon glyphicon-ok"></span> ' + message;
        errorDiv.style.display = 'block';
        errorDiv.className = 'alert alert-success';
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errorDiv.style.display = 'none';
        
        const username = usernameInput.value.trim();
        const password = passwordInput.value;
        const siteUrl = siteUrlInput.value.replace(/\/$/, '');

        if (!username || !password || !siteUrl) {
            showError('Please fill in all required fields.');
            return;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Verifying...';
        submitBtn.disabled = true;

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
                showSuccess(data.message || 'Credentials verified successfully!');

                // After verifying credentials, the browser should register the shared secret with the WP site
                const sharedSecret = document.getElementById('shared_secret').value;
                const addTokenUrl = siteUrl + '/wp-json/laravel-sso/v1/add-secret-token?token=' + encodeURIComponent(sharedSecret) + '&url=' + encodeURIComponent(window.location.origin) + '&redirect=';

                fetch(addTokenUrl, { method: 'GET', mode: 'cors' })
                    .then(async addResp => {
                        // If endpoint responds JSON, try to parse it, otherwise treat non-2xx as error
                        if (!addResp.ok) {
                            const txt = await addResp.text().catch(() => '');
                            throw new Error('Failed to register token on remote site. ' + (txt || addResp.statusText));
                        }
                        // Token registered successfully — submit the form to save credentials on our side
                        setTimeout(() => form.submit(), 500);
                    })
                    .catch(err => {
                        showError('Could not register token on the remote site: ' + (err.message || err));
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    });

            } else {
                showError(data.message || 'Invalid credentials. Please try again.');
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        })
        .catch(() => {
            showError('Could not connect to the site or API. Please check the URL and try again.');
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    });
});
</script>

<style>
.glyphicon-refresh-animate {
    animation: spin 1s infinite linear;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@media (max-width: 767px) {
    .btn-block-xs {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endsection

@section('scripts')
    @stack('scripts')
@endsection

@stop
