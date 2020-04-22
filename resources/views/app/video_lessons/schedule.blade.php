@extends('layouts.theApp')
@section('title')
    {{__('Schedule a lesson with')}} {{$teacher->name}}
@endsection

@section('toolbar_right')

@endsection

@section('content')
    <schedule_form
        :teacher="{{json_encode($teacher)}}"
        available-times-endpoint="{{route('api.video_lesson.fetchAvailabilityDate')}}"
    ></schedule_form>
@endsection
