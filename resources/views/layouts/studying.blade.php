<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>JapaLearn</title>

    @include('layouts.header')
    @yield('scripts')
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />

    @if(env('APP_ENV') == "production")
        @include('layouts.parts.analytics')
        <script src="https://www.google.com/recaptcha/api.js?render=6LcmAwAVAAAAAAnM-_UF8eg6L_YMNCj67S_2FHKu"></script>
        @include('layouts.parts.pixel')
    @endif
</head>
<body>
<div id="app" class="page-container md-layout-column">
    <study-page>
        <template v-slot:title>
            @yield('title')
        </template>

        <template v-slot:toolbar_right>
            @yield('toolbar_right')
        </template>

        <!-- Page Content -->
        <template v-slot:content>
            @yield('content')
        </template>
    </study-page>

    <!-- Snack Bar flash messages -->
    @if(Session::has('message'))
        <flash message="{{Session::get('message')}}"></flash>
    @endif
</div>

</body>
</html>
