<<<<<<< HEAD
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row visible-xs">
        <div class="col-xs-12">
            <div class="page-header">
                <h1 class="h3">Add Website URL</h1>
            </div>
        </div>
    </div>

    <!-- Breadcrumb - Hidden on mobile -->
    <div class="row hidden-xs">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li class="active">Add Website URL</li>
            </ol>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading hidden-xs">
                    <h3 class="panel-title">Add New Website</h3>
                </div>
                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok"></span> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><span class="glyphicon glyphicon-exclamation-sign"></span> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="add-url-form" action="" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label for="url" class="col-xs-12 col-sm-3 col-md-2 control-label">Website URL</label>
                            <div class="col-xs-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                    <input type="url" name="url" id="url" class="form-control" 
                                           placeholder="https://example.com" value="{{ old('url') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                                <div id="plugin-error" class="alert alert-danger" style="display:none;"></div>
                                <button type="submit" id="next-btn" class="btn btn-primary btn-block-xs">
                                    <span class="glyphicon glyphicon-arrow-right"></span> Next
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('custom_js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-url-form');
    const urlInput = document.getElementById('url');
    const errorDiv = document.getElementById('plugin-error');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';
        
        const nextBtn = document.getElementById('next-btn');
        const originalBtnContent = nextBtn.innerHTML;
        nextBtn.innerHTML = '<span class="glyphicon glyphicon-refresh glyphicon-spin"></span> Checking...';
        nextBtn.disabled = true;
        
        const siteUrl = urlInput.value.replace(/\/$/, '');
        if (!siteUrl) {
            errorDiv.textContent = 'Please enter a valid URL.';
            errorDiv.style.display = 'block';
            nextBtn.innerHTML = originalBtnContent;
            nextBtn.disabled = false;
            return;
        }

        fetch(siteUrl + '/wp-json/laravel-sso/v1/check-plugin', {
            method: 'GET',
        })
        .then(response => {
            if (response.ok) {
                errorDiv.className = 'alert alert-success';
                errorDiv.innerHTML = '<span class="glyphicon glyphicon-ok"></span> Plugin detected! Proceeding...';
                errorDiv.style.display = 'block';
                setTimeout(() => {
                    form.submit();
                }, 1500);
            } else {
                throw new Error('Plugin not available on this site.');
            }
        })
       .catch(() => {
            errorDiv.className = 'alert alert-danger';
            errorDiv.innerHTML = '<span class="glyphicon glyphicon-exclamation-sign"></span> The required plugin is not available or the site is unreachable. <a href="{{ route('download') }}" class="alert-link">Click here to download plugin</a>.';
            errorDiv.style.display = 'block';
            nextBtn.innerHTML = originalBtnContent;
            nextBtn.disabled = false;
        });
    });
});
</script>
@endsection

@section('scripts')
    @stack('scripts')
@endsection

=======
@extends('adminlte::page')

@section('title', 'Add Website URL')

@section('content_header')
    <h1>Add Website URL</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="" method="POST">
        @csrf
        <div class="form-group">
            <label for="url">Website URL</label>
            <input type="url" name="url" id="url" class="form-control" placeholder="https://example.com" value="{{ old('url') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Next</button>
    </form>
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
@stop
