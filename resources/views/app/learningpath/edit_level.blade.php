@extends('layouts.theApp')
@section('title')
    {{__('Edit level')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('learningpath.vocab.index')}}">{{__('Back')}}</md-button>
@endsection

@section('content')
    <h2>{{__('Radicals')}} - {{$radicals->count()}}</h2>
    @foreach($radicals as $radical)
        <md-card class="col-md-2 vocab_learning_path_view_item">
            <p class="word_title">{{$radical->vocabulary->word}}</p>
            <p class="word_meaning">{{$radical->meanings[0]->meaning}}</p>
        </md-card>
    @endforeach

    <h2>{{__('Kanjis')}} - {{$kanjis->count()}}</h2>
    @foreach($kanjis as $kanji)
        <md-card class="col-md-2 vocab_learning_path_view_item">
            <p class="word_title">{{$kanji->vocabulary->word}}</p>
            <p class="word_meaning">{{$kanji->vocabulary->meanings[0]->meaning}}</p>
        </md-card>
    @endforeach

    <h2>{{__('Vocabulary')}} - {{$vocabulary->count()}}</h2>
    <div class="row">
        @foreach($vocabulary as $vocab)
            <md-card class="col-md-2 vocab_learning_path_view_item">
{{--                <p class="word_title">{{$vocab->vocabulary->word}}</p>--}}
{{--                <p class="word_meaning">{{$vocab->vocabulary->meanings[0]->meaning}}</p>--}}
            </md-card>
        @endforeach
    </div>
@endsection
