@extends('layouts.theApp')
@section('title')
    {{__('Your profile')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')
    <md-content>
        <h1>Profile</h1>
    </md-content>
@endsection
