<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>JapaLearn</title>

    @include('layouts.header')
    @yield('scripts')
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

        <chat
            conversation-endpoint="{{route('api.chat.get_conversations')}}"
            send-message-endpoint="{{route('api.chat.send')}}"
            current-user-id="{{Auth::user()->id}}"
            :friends="{{Auth::user()->friends}}"
        ></chat>

        <!-- Snack Bar flash messages -->
        @if(Session::has('message'))
            <flash message="{{Session::get('message')}}"></flash>
        @endif
    </div>

</body>
</html>
