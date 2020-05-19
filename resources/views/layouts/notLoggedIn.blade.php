<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('seo_info')

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
                <img alt="The JapaLearn logo" src="/images/logo/logo_web_small.png" class="logo"/>
                <div class="md-toolbar-section-end">

                    <md-button href="{{route('frontpage.home')}}">Home</md-button>
                    <md-button href="{{route('frontpage.grammar')}}">Grammar</md-button>
                    <md-button href="{{route('frontpage.stories')}}">Japanese stories</md-button>
                    <md-button href="{{route('frontpage.blog')}}">Blog</md-button>

                    <div class="nav-separator d-none d-lg-block"></div>

                    @if(Auth::guest())
                        <md-button href="{{route('login')}}">Login</md-button>
                        <md-button href="{{route('register')}}">Register</md-button>
                    @else
                        <md-button href="{{route('dashboard')}}">Dashboard<md-icon>arrow_forward_ios</md-icon></md-button>
                    @endif

                </div>
            </md-app-toolbar>
            <md-app-content class="frontpage-content">
                @yield('content')

            </md-app-content>


        </md-app>

        <!-- Snack Bar flash messages -->
        @if(Session::has('message'))
            <flash message="{{Session::get('message')}}"></flash>
        @endif
    </div>

    <footer>
        <div class="copyright">
            <p>© Copyright {{now()->format("Y")}}, JapaLearn</p>
        </div>
    </footer>

</body>
</html>
