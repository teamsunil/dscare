@extends('adminlte::page')

@section('title', 'Add Website Credentials')

@section('content_header')
    <h1>Enter Website Credentials</h1>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('website.submit.credentials') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Email</label>
            <input type="email" placeholder="Email" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="form-group mt-2">
            <label for="password">Password</label>
            <input type="password" placeholder="Password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
@stop
