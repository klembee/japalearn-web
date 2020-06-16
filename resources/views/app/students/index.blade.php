@extends('layouts.theApp')
@section('title')
    {{__('Your students')}}
@endsection

@section('seo')
    <title>Student list</title>
@endsection

@section('toolbar_right')
    <student-invitation-dialog
        code-generation-endpoint="{{route('api.teachers.generate_invite_code')}}"
        code-accept-link="{{route('join-teacher', ['code' => "THE_CODE"])}}"/>
@endsection

@section('content')
    <md-table>
        <md-table-row>
            <md-table-head>{{__('Name')}}</md-table-head>
            <md-table-head>{{__('Email')}}</md-table-head>
        </md-table-row>
        @foreach($students as $student)
            <md-table-row>
                <md-table-cell>{{$student->name}}</md-table-cell>
                <md-table-cell>{{$student->email}}</md-table-cell>
            </md-table-row>
        @endforeach
    </md-table>
@endsection
