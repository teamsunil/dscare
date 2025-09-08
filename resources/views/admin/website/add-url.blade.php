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
@stop
