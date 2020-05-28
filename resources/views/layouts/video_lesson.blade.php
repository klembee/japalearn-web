<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>JapaLearn - Video lesson</title>

    @include('layouts.header')
    <link href="{{ mix('css/dark_app.css') }}" rel="stylesheet">
    @yield('scripts')
</head>
<body>
<div id="app" class="page-container md-layout-column">
    @include('layouts.flash')

    <md-content>
        @yield('content')
    </md-content>
</div>

</body>
</html>
