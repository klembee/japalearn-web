@extends('layouts.theApp')
@section('title')
    {{__('Subscription')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')

    <subscription-page
        subscribe-endpoint="{{route('api.payment.subscribe')}}"
        redirect-url="{{route('dashboard')}}"
        :month="{{json_encode($monthlyPlan)}}"
        :trimonth="{{json_encode($trimonthlyPlan)}}"
        :year="{{json_encode($annualPlan)}}"
        :credit-cards="{{json_encode($creditCards)}}"
        save-method-endpoint="{{route('api.payment.add-payment-method')}}"
        stripe-key="{{env('STRIPE_KEY')}}"
        client-secret="{{$stripeIntent}}"
    >

    </subscription-page>

@endsection
