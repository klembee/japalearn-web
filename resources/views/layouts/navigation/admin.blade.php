@extends('layouts.navigation.base_nav')
@section('top')
    <!-- Go to the users page -->
    <md-list-item href="{{route('users.index')}}" exact>
        <md-icon>people</md-icon>
        <span class="md-list-item-text">{{__('Users')}}</span>
    </md-list-item>
    <md-list-item href="{{route('learning_path.vocab.index')}}" exact>
        <md-icon>map</md-icon>
        <span class="md-list-item-text">{{__('Kanji Leaning Paths')}}</span>
    </md-list-item>

    <md-list-item href="{{route('learning_path.grammar.index')}}" exact>
        <md-icon>map</md-icon>
        <span class="md-list-item-text">{{__('Grammar Leaning Paths')}}</span>
    </md-list-item>
@endsection
@section('bottom')

@endsection
