<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.layouts.header-tag')
    <link rel="stylesheet" href="{{ mix('/assets/css/app.css') }}">
    @routes
    <script src="{{ mix('/assets/js/app.js') }}" defer></script>
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
