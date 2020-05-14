@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div>
        Welcome to your dashboard !
        <learning-journey
            :done-basic-kanas="{{$doneBasicKanas ? 'true' : 'false'}}"
        ></learning-journey>
    </div>
@endsection
