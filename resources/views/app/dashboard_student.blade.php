@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('study.vocab')}}">{{__('Study')}}</md-button>
@endsection

@section('content')
    <p>Dashboard</p>
@endsection
