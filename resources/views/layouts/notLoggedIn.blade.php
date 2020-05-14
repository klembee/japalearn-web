<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>JapaLearn - Learn Japanese the right way !</title>
    <meta property="og:title" content="JapaLearn - Learn Japanese the right way !">
    <meta property="og:image" content="/images/facebook-share.jpg">

    @include('layouts.header')
    @yield('scripts')
</head>
<body>
    <div id="app" class="page-container md-layout-column">
        <md-app style="min-height: 100vh;">
            <md-app-toolbar class="md-primary">
                <md-button class="md-icon-button d-sm-none" @click="showNavigation = true">
                    <md-icon>menu</md-icon>
                </md-button>
                <span class="md-title">JapaLearn</span>
                <div class="md-toolbar-section-end">
                    <md-button href="{{route('login')}}">Login</md-button>
                    <md-button href="{{route('register')}}">Register</md-button>
                </div>
            </md-app-toolbar>
            <md-app-content>
                @yield('content')
            </md-app-content>
        </md-app>

        <!-- Snack Bar flash messages -->
        @if(Session::has('message'))
            <flash message="{{Session::get('message')}}"></flash>
        @endif
    </div>
</body>
</html>
