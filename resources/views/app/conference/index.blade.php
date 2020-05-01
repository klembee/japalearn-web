@extends('layouts.theApp')
@section('title')
    {{__('Conference')}}
@endsection

@section('content')
    <conference-room
        :meeting-response="{{json_encode($meeting)}}"
        :attendees-response="{{json_encode($attendee)}}"
    ></conference-room>
@endsection
