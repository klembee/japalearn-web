@extends('layouts.video_lesson')
@section('title')
    {{__('Conference')}}
@endsection

@section('content')
    <conference-room
        dashboard-url="{{route('dashboard')}}"
        send-message-endpoint="{{route('api.chat.send')}}"
        :own-id="{{Auth::user()->id}}"
        :other-id="{{$otherId}}"
        :messages="{{json_encode($messages)}}"
        :meeting-response="{{json_encode($awsMeeting)}}"
        :attendees-response="{{json_encode($awsAttendee)}}"
    ></conference-room>
@endsection
