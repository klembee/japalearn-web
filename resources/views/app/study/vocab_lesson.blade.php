@extends('layouts.studying')
@section('title')
    {{__('Kanji lesson')}}
@endsection

@section('seo')
    <title>Vocab lesson</title>
@endsection

@section('toolbar_right')
    <md-button href="{{route('kanji_vocabulary.index')}}">{{__('Exit')}}</md-button>
@endsection

@section('content')

    <vocab-lesson-window
        update-levels-endpoint="{{route('api.learning_path.kanji.items.review.update_level')}}"
        dashboard-url="{{route('kanji_vocabulary.index')}}"
        :items="{{$items}}"
        type="vocab"
    ></vocab-lesson-window>
@endsection
