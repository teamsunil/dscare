<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DS Care @yield('title', '')</title>
    <link rel="icon" type="image/x-icon" href="https://www.pikpng.com/pngl/b/129-1298094_dotsquares-logo-png-clipart.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://www.pikpng.com/pngl/b/129-1298094_dotsquares-logo-png-clipart.png">
     @include('admin.include.css_script')
     @yield('custom_css')
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader"></div>
    </div>
    
    @include('admin.include.header')

    @yield('content')

    @include('admin.include.footer')

    @include('admin.include.js_script')

    @yield('custom_js')
</body>
</html>