@extends('layouts.studying')
@section('title')
    {{__('Kana review')}}
@endsection

@section('seo')
    <title>Kana review</title>
@endsection

@section('toolbar_right')
    <md-button href="{{route('kanas.index')}}">{{__('Exit')}}</md-button>
@endsection

@section('content')
    <vocab-review-window
        update-levels-endpoint="{{route('api.learning_path.kana.review.update_level')}}"
        dashboard-url="{{route('kanas.index')}}"
        :reviews="{{$reviews}}"
        type="kana"
    >

    </vocab-review-window>

@endsection
