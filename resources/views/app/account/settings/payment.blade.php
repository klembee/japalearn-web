@extends('layouts.theApp')
@section('title')
    {{__('Payment processing')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')
    <md-content>
        <h1>Payment</h1>
    </md-content>
@endsection
