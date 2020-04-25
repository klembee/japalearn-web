<!-- Dashboard link -->
<md-list-item href="{{route('dashboard')}}" exact>
    <md-icon>dashboard</md-icon>
    <span class="md-list-item-text">{{__('Dashboard')}}</span>
</md-list-item>
<md-divider></md-divider>
@yield('top')

<md-divider></md-divider>
@yield('bottom')

<md-divider></md-divider>
<md-subheader>{{__('Account')}}</md-subheader>

<!-- Account button -->
<md-list-item href="{{route('account.profile.index')}}">
    <md-icon>account_box</md-icon>
    <span class="md-list-item-text">{{__('Your account')}}</span>
</md-list-item>

<!-- Log Out link -->
<md-list-item href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
    <md-icon>exit_to_app</md-icon>
    <span class="md-list-item-text">{{__('Log Out')}}</span>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
</md-list-item>
