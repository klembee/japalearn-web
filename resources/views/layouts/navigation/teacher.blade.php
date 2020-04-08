@extends('layouts.navigation.base_nav')
@section('top')
    <md-list-item href="{{route('students.index')}}" exact>
        <md-icon>people</md-icon>
        <span class="md-list-item-text">{{__('Students')}}</span>
    </md-list-item>
@endsection
@section('bottom')

@endsection
