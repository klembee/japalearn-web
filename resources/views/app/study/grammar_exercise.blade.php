@extends('layouts.studying')
@section('title')
    {{__('Grammar review')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('grammar.learn', $grammarlesson)}}">{{__('Exit')}}</md-button>
@endsection

@section('content')
    <grammar-reviews
        :questions="{{json_encode($questions)}}"
        last-lesson-url="{{route('grammar.learn', $grammarlesson)}}"
        next-lesson-url="{{$nextLesson ? route('grammar.learn', $nextLesson) : ''}}"
    ></grammar-reviews>
@endsection
