@extends('layouts.video_lesson')
@section('title')
    {{__('Conference')}}
@endsection

@section('content')
    <conference-room
        :meeting-response="{{json_encode($awsMeeting)}}"
        :attendees-response="{{json_encode($awsAttendee)}}"
    ></conference-room>
@endsection
