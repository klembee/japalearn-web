@extends('layouts.theApp')
@section('title')
    {{__('Users')}}
@endsection

@section('seo')
    <title>User list</title>
@endsection

@section('toolbar_right')
    <md-button href="{{route('users.create')}}">{{__('Create User')}}</md-button>
@endsection

@section('content')
    <md-table>
        <md-table-row>
            <md-table-head md-numeric>{{__('ID')}}</md-table-head>
            <md-table-head>{{__('Name')}}</md-table-head>
            <md-table-head>{{__('Email')}}</md-table-head>
            <md-table-head>{{__('Role')}}</md-table-head>
        </md-table-row>
        @foreach($users as $user)
                <md-table-row onclick="window.location='{{route('users.view', $user)}}'">
                    <md-table-cell md-numeric>{{$user->id}}</md-table-cell>
                    <md-table-cell>{{$user->name}}</md-table-cell>
                    <md-table-cell>{{$user->email}}</md-table-cell>
                    <md-table-cell>{{$user->role->name}}</md-table-cell>
                </md-table-row>

        @endforeach
    </md-table>

    <div class="mt-3 mx-auto" style="width:fit-content;">
        {{$users->links()}}
    </div>

@endsection
