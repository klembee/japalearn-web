<md-tabs>
    <md-tab href="{{route('account.profile.index')}}" md-label="{{__('Profile')}}"></md-tab>
{{--    <md-tab href="{{route('account.learning.index')}}" md-label="{{__('Learning')}}"></md-tab>--}}

{{--    <md-tab href="{{route('account.emails.index')}}" md-label="{{__('Email preferences')}}"></md-tab>--}}

    @if(Auth::user()->isStudent())
        <md-tab href="{{route('account.payment.index')}}" md-label="{{__('Payments')}}"></md-tab>
        <md-tab href="{{route('account.subscription.index')}}" md-label="{{__('Subscription')}}"></md-tab>
    @endif

    @if(Auth::user()->isTeacher())
        <md-tab href="{{route('account.getpaid.index')}}" md-label="{{__('Get paid')}}"></md-tab>
    @endif
</md-tabs>
