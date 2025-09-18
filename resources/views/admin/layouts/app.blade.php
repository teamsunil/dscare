<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     @include('admin.include.css_script')
     @yield('custom_css')
</head>
<body>
    @include('admin.include.header')

    @yield('content')

    @include('admin.include.footer')

    @include('admin.include.js_script')

    @yield('custom_js')
</body>
</html>