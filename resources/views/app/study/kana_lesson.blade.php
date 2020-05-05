@extends('layouts.studying')
@section('title')
    {{__('Kana review')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('kanas.index')}}">{{__('Exit')}}</md-button>
@endsection

@section('content')
    <vocab-lesson-window
        update-levels-endpoint="{{route('api.learning_path.kana.review.update_level')}}"
        dashboard-url="{{route('kanas.index')}}"
        :items="{{$items}}"
        type="kana"
    ></vocab-lesson-window>
@endsection
