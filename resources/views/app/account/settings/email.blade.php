@extends('layouts.theApp')
@section('title')
    {{__('Learning experience')}}
@endsection

@section('seo')
    <title>Settings - email</title>
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')
    <md-content>
        <h1>Email preferences</h1>
    </md-content>
@endsection
