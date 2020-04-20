@extends('layouts.theApp')
@section('title')
    {{__('Your profile')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')
    <md-content>
        @include('app.account.settings.profile.form')
    </md-content>
@endsection
