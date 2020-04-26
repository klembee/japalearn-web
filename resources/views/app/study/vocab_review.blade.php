@extends('layouts.studying')
@section('title')
    {{__('Vocabulary review')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('dashboard')}}">{{__('Exit')}}</md-button>
@endsection

@section('content')

    <vocab-review-window
        update-levels-endpoint="{{route('api.kanji_learning_path.items.review.update_level')}}"
        dashboard-url="{{route('dashboard')}}"
        :reviews="{{$reviews}}"
    >

    </vocab-review-window>
@endsection
