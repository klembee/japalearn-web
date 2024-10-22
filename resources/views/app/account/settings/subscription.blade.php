@extends('layouts.theApp')
@section('title')
    {{__('Subscription')}}
@endsection

@section('seo')
    <title>Settings - subscription</title>
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')

    @if($currentlySubscribed)
        <h1 class="mt-3">Current subscription</h1>
        <table class="table">
            <tr>
                <td>Amount</td>
                <td>${{$subscription['items']['data'][0]['plan']['amount'] / 100}} CAD</td>
            </tr>
            <tr>
                <td>Interval</td>
                @if($subscription['items']['data'][0]['plan']['interval'] == 'month' && $subscription['items']['data'][0]['plan']['interval_count'] == 1)
                    <td>Every month</td>
                @elseif($subscription['items']['data'][0]['plan']['interval'] == 'month' && $subscription['items']['data'][0]['plan']['interval_count'] == 3)
                    <td>Every 3 month</td>
                @elseif($subscription['items']['data'][0]['plan']['interval'] == 'year')
                    <td>Every year</td>
                @endif
            </tr>
            <tr>
                <td>Next payment date</td>
                @if($subscription['cancel_at_period_end'])
                    <td>Canceled</td>
                @else
                    <td>{{\Carbon\Carbon::createFromTimestamp($subscription['current_period_end'])->format("Y-m-d")}}</td>
                @endif
            </tr>
        </table>
        @if(!$subscription['cancel_at_period_end'])
            <md-button href="{{route('account.unsubscribe')}}" class="md-primary md-raised">{{__('Cancel subscription')}}</md-button>
        @else
            <div class="alert alert-danger">
                Your subscription will end on {{\Carbon\Carbon::createFromTimestamp($subscription['current_period_end'])->format("Y-m-d")}}. You will not be charged again.
            </div>
        @endif
{{--        <pre>--}}
{{--            {{print_r($subscription, true)}}--}}
{{--        </pre>--}}
    @else
        <subscription-page
            user-email="{{Auth::user()->email}}"
            subscribe-endpoint="{{route('api.payment.subscribe')}}"
            redirect-url="{{route('dashboard')}}"
            :month="{{json_encode($monthlyPlan)}}"
            :trimonth="{{json_encode($trimonthlyPlan)}}"
            :year="{{json_encode($annualPlan)}}"
            :credit-cards="{{json_encode($creditCards)}}"
            save-method-endpoint="{{route('api.payment.add-payment-method')}}"
            stripe-key="{{env('STRIPE_KEY')}}"
            client-secret="{{$stripeIntent}}"
            :has-taxes="false"
        >

        </subscription-page>
    @endif

@endsection
