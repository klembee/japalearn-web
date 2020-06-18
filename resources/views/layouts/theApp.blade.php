<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.header')
    @yield('scripts')

    @yield('seo')

    @if(env('APP_ENV') == "production")
        @include('layouts.parts.mailchimp')
        @include('layouts.parts.analytics')
        <script src="https://www.google.com/recaptcha/api.js?render=6LcmAwAVAAAAAAnM-_UF8eg6L_YMNCj67S_2FHKu"></script>
        @include('layouts.parts.pixel')

    @else
        <!-- Dev version of analytics -->

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-165388196-2', 'auto');
            ga('send', 'pageview');
        </script>

    @endif
</head>
<body>
    <div id="app" class="page-container md-layout-column">
        @include('layouts.flash')

        <dashboard>
            <template v-slot:title>
                @yield('title')
            </template>

            <template v-slot:alert>
                @yield('alert')
            </template>

            <template v-slot:toolbar_right>
                @yield('toolbar_right')
            </template>

            <template v-slot:navigation-items>
                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                    @include('layouts.navigation.admin')
                @elseif(\Illuminate\Support\Facades\Auth::user()->isModerator())
                    @include('layouts.navigation.moderator')
                @elseif(\Illuminate\Support\Facades\Auth::user()->isStudent())
                    @include('layouts.navigation.student')
                @elseif(\Illuminate\Support\Facades\Auth::user()->isTeacher())
                    @include('layouts.navigation.teacher')
                @endif
            </template>
            <!-- Page Content -->
            <template v-slot:content>
                @yield('content')
            </template>
        </dashboard>

        <contact-fab
            post-url="{{route('api.frontpage.contactus')}}"
        ></contact-fab>

{{--        <chat--}}
{{--            conversation-endpoint="{{route('api.chat.get_conversations')}}"--}}
{{--            send-message-endpoint="{{route('api.chat.send')}}"--}}
{{--            current-user-id="{{Auth::user()->id}}"--}}
{{--            :friends="{{Auth::user()->friends}}"--}}
{{--        ></chat>--}}

        <!-- Snack Bar flash messages -->
{{--        @if(Session::has('error'))--}}
{{--            <flash--}}
{{--                message="{{Session::get('message')}}"--}}
{{--                type="error"></flash>--}}
{{--        @endif--}}
    </div>

</body>
</html>
