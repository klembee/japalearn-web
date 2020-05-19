@extends('layouts.navigation.base_nav')
@section('top')
    <!-- Go to the users page -->
    <md-list-item href="{{route('users.index')}}" exact>
        <md-icon>people</md-icon>
        <span class="md-list-item-text">{{__('Users')}}</span>
    </md-list-item>

    <!-- Go blog page -->
    <md-list-item href="{{route('blog.index')}}" exact>
        <md-icon>book</md-icon>
        <span class="md-list-item-text">{{__('Blog')}}</span>
    </md-list-item>

    <!-- Kana learning path -->
    <md-list-item href="{{route('learning_path.kana.index')}}" exact>
        <md-icon>map</md-icon>
        <span class="md-list-item-text">{{__('Kana Leaning Paths')}}</span>
    </md-list-item>

    <!-- kanji and vocab learning path -->
    <md-list-item href="{{route('learning_path.vocab.index')}}" exact>
        <md-icon>map</md-icon>
        <span class="md-list-item-text">{{__('Kanji Leaning Paths')}}</span>
    </md-list-item>

    <!-- Grammar learning path -->
    <md-list-item href="{{route('learning_path.grammar.index')}}" exact>
        <md-icon>map</md-icon>
        <span class="md-list-item-text">{{__('Grammar Leaning Paths')}}</span>
    </md-list-item>

    <!-- Stories -->
    <md-list-item href="{{route('learning_path.stories.index')}}" exact>
        <md-icon>map</md-icon>
        <span class="md-list-item-text">{{__('Stories')}}</span>
    </md-list-item>
@endsection
@section('bottom')

@endsection
