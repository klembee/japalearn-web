<md-tabs>
    <md-tab href="{{route('account.profile.index')}}" md-label="{{__('Profile')}}"></md-tab>
    <md-tab href="{{route('account.learning.index')}}" md-label="{{__('Learning')}}"></md-tab>
    @if(Auth::user()->isStudent())
        <md-tab href="{{route('account.payment.index')}}" md-label="{{__('Payments')}}"></md-tab>
    @endif
</md-tabs>
