@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div>
        Welcome to your dashboard !
        <learning-journey></learning-journey>
    </div>
@endsection
