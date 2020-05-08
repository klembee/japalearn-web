@extends('layouts.theApp')
@section('title')
    {{__('Subscription')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')

    <subscription-page
        :month="{{json_encode($monthlyPlan)}}"
        :trimonth="{{json_encode($trimonthlyPlan)}}"
        :year="{{json_encode($annualPlan)}}"
    >

    </subscription-page>

@endsection
