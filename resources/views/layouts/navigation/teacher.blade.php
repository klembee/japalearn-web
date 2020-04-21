@extends('layouts.navigation.base_nav')
@section('top')
    <md-list-item href="{{route('students.index')}}" exact>
        <md-icon>people</md-icon>
        <span class="md-list-item-text">{{__('Students')}}</span>
    </md-list-item>
    <md-list-item href="{{route('video_lesson.index')}}">
        <md-icon>video_call</md-icon>
        <span class="md-list-item-text">{{__('Video Lessons')}}</span>
    </md-list-item>
@endsection
@section('bottom')

@endsection
