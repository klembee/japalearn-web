@extends('layouts.theApp')
@section('title')
    {{__('Your teachers')}}
@endsection

@section('content')
    <md-table>
        <md-table-row>
            <md-table-head>{{__('Name')}}</md-table-head>
            <md-table-head>{{__('Email')}}</md-table-head>
            <md-table-head>{{__('action')}}</md-table-head>
        </md-table-row>
        @foreach($teachers as $teacher)
            <md-table-row>
                <md-table-cell>{{$teacher->name}}</md-table-cell>
                <md-table-cell>{{$teacher->email}}</md-table-cell>
                <md-table-cell>
                    <md-button href="{{route('video_lesson.schedule.index', ['teacher' => $teacher->id])}}" class="md-raised md-primary">{{__('Schedule lesson')}}</md-button>
                </md-table-cell>
            </md-table-row>
        @endforeach
    </md-table>
@endsection
