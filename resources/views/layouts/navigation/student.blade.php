@extends('layouts.navigation.base_nav')
@section('top')

    <md-subheader>{{__('Learn')}}</md-subheader>

    <md-list-item href="{{route('kanas.index')}}">
        <md-icon>あ</md-icon>
        <span class="md-list-item-text">{{__('Kanas')}}</span>
    </md-list-item>

    <md-list-item href="{{route('kanji_vocabulary.index')}}">
        <md-icon>東</md-icon>
        <span class="md-list-item-text">{{__('Kanji')}}</span>
    </md-list-item>

    <md-list-item href="{{route('grammar.index')}}" exact>
        <md-icon>spellcheck</md-icon>
        <span class="md-list-item-text">{{__('Grammar')}}</span>
    </md-list-item>

    <md-list-item href="{{route('reading.index')}}" exact>
        <md-icon>subject</md-icon>
        <span class="md-list-item-text">{{__('Reading')}}</span>
    </md-list-item>

    <md-list-item href="{{route('listening.index')}}" exact>
        <md-icon>theaters</md-icon>
        <span class="md-list-item-text">{{__('Listening')}}</span>
    </md-list-item>

    <md-list-item href="{{route('teachers.index')}}" exact>
        <md-icon>people</md-icon>
        <span class="md-list-item-text">{{__('Teachers')}}</span>
    </md-list-item>

    <md-divider></md-divider>
    <md-subheader>{{__('Utils')}}</md-subheader>

    <md-list-item href="{{route('dictionary.index')}}" exact>
        <md-icon>menu_book</md-icon>
        <span class="md-list-item-text">{{__('Dictionary')}}</span>
    </md-list-item>
@endsection

@section('bottom')

@endsection
