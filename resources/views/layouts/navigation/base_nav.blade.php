<!-- Dashboard link -->
<md-list-item href="{{route('dashboard')}}" exact>
    <md-icon>dashboard</md-icon>
    <span class="md-list-item-text">{{__('Dashboard')}}</span>
</md-list-item>
<md-list-item href="{{route('dictionary.index')}}" exact>
    <md-icon>menu_book</md-icon>
    <span class="md-list-item-text">{{__('Dictionary')}}</span>
</md-list-item>
@yield('top')

<md-divider class="md-inset"></md-divider>
@yield('bottom')
<!-- Log Out link -->
<md-list-item href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
    <md-icon>exit_to_app</md-icon>
    <span class="md-list-item-text">{{__('Log Out')}}</span>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
</md-list-item>
