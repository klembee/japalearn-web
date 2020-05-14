@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div>
        Welcome to your dashboard !
        <learning-journey
            :done-basic-kanas="{{$doneBasicKanas ? 'true' : 'false'}}"
            kana-url="{{route('study.kana.lesson')}}"
        ></learning-journey>
    </div>
@endsection
