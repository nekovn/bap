<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.layouts.header-tag')
    <link rel="stylesheet" href="{{ mix('/assets/css/app.css') }}" defer
          integrity="{{ \App\Helpers\SystemHelper::file_integrity('/assets/css/app.css') }}">
    @routes
    <script src="{{ mix('/assets/js/app.js') }}" defer type="text/javascript"
            integrity="{{ \App\Helpers\SystemHelper::file_integrity('/assets/js/app.js') }}"></script>
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
