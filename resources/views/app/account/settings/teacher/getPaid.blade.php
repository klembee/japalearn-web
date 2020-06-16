@extends('layouts.theApp')
@section('title')
    {{__('Get paid')}}
@endsection

@section('seo')
    <title>Settings - Get paid</title>
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')

    <md-content class="mt-3">
        @if(!$stripeSettedUp)
            <p>Please setup your stripe account to start doing video lesson with students.</p>

            <md-button
                class="md-raised md-primary"
                href="https://connect.stripe.com/express/oauth/authorize?client_id=ca_H6v5WaI8qXpgzmqjOWtRg0YmkElxjEGf&state={{$user->info->stripe_state}}&suggested_capabilities[]=transfers&stripe_user[email]={{$user->email}}&stripe_user[country]=CA&stripe_user[first_name]={{$user->firstname}}&stripe_user[first_name]={{$user->lastname}}&stripe_user[currency]=cad">Setup stripe account</md-button>
        @else
            <p>Your stripe account has been set up. You can now do video lessons and get paid.</p>
        @endif
    </md-content>


{{--    <md-content>--}}
{{--        <h1>Learning experience</h1>--}}
{{--    </md-content>--}}
@endsection
