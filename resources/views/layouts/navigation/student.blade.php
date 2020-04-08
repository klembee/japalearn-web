@extends('layouts.navigation.base_nav')
@section('top')
    <md-list-item href="{{route('teachers.index')}}" exact>
        <md-icon>bookmarks</md-icon>
        <span class="md-list-item-text">{{__('Vocabulary')}}</span>
    </md-list-item>
    <md-list-item href="{{route('teachers.index')}}" exact>
        <md-icon>people</md-icon>
        <span class="md-list-item-text">{{__('Teachers')}}</span>
    </md-list-item>
@endsection
@section('bottom')

@endsection
