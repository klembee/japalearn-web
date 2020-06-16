@extends('layouts.studying')
@section('title')
    {{__('Grammar review')}}
@endsection

@section('seo')
    <title>Grammar exercises</title>
@endsection

@section('toolbar_right')
    <md-button href="{{route('grammar.learn', $grammarlesson)}}">{{__('Exit')}}</md-button>
@endsection

@section('content')
    <grammar-reviews
        :questions="{{json_encode($questions)}}"
        last-lesson-url="{{route('grammar.learn', $grammarlesson)}}"
        next-lesson-url="{{$nextLesson ? route('grammar.learn', $nextLesson) : ''}}"
        update-grammar-level-endpoint="{{route('api.learning_path.grammar.update-level')}}"
    ></grammar-reviews>
@endsection
