@extends('layouts.theApp')
@section('title')
    {{__('Your teachers')}}
@endsection

@section('seo')
    <title>Your teachers</title>
@endsection

@section('content')
    @foreach($teachers as $teacher)
        <teacher-card
            :teacher="{{json_encode($teacher)}}"
            schedule-lesson-url={{route('video_lesson.schedule.index', ['teacher' => $teacher])}}
        ></teacher-card>
    @endforeach
@endsection
