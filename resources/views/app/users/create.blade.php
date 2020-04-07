@extends('layouts.theApp')
@section('title')
    {{__('Create User')}}
@endsection

@section('content')
    <form method="post" action="{{route('users.store')}}" id="createUserForm" class="md-layout">
        @csrf

        <div class="md-title">{{__("User's information")}}</div>
        <md-field>
            <label for="name">{{__('Name')}}</label>
            <md-input name="name" id="name" type="text" required autocomplete="name"></md-input>
        </md-field>

        <md-field>
            <label for="email">{{__('Email')}}</label>
            <md-input name="email" id="email" type="email" required autocomplete="emdail"></md-input>
        </md-field>

        <md-field>
            <label for="password">{{__('Password')}}</label>
            <md-input name="password" id="password" type="password" required autocomplete="pasdsword"></md-input>
        </md-field>

        <md-button type="submit" class="md-primary">{{__('Save')}}</md-button>
    </form>
@endsection
