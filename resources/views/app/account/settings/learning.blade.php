@extends('layouts.theApp')
@section('title')
    {{__('Learning experience')}}
@endsection

@section('seo')
    <title>Settings - learning</title>
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')
    <md-content>
        <h1>Learning experience</h1>
    </md-content>
@endsection
