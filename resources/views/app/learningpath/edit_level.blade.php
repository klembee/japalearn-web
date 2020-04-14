@extends('layouts.theApp')
@section('title')
    {{__('Edit level')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('learningpath.vocab.index')}}">{{__('Back')}}</md-button>
@endsection

@section('content')
    <h2>{{__('Radicals')}} - {{$radicals->count()}}</h2>
    <div class="row mb-3">
        @foreach($radicals as $radical)
            <md-card class="mb-4 col-md-2 col-sm-4 col-6 vocab_learning_path_view_item" md-with-hover>
                <p class="word_title">{{$radical->word}}</p>
                <p class="word_meaning">{{$radical->meanings[0]->meaning}}</p>
            </md-card>
        @endforeach
    </div>

    <h2>{{__('Kanjis')}} - {{$kanjis->count()}}</h2>
    <div class="row mb-3">
        @foreach($kanjis as $kanji)
            <md-card class="mb-4 col-md-2 col-sm-4 col-6 vocab_learning_path_view_item" md-with-hover>
                <p class="word_title">{{$kanji->word}}</p>
                <p class="word_meaning">{{$kanji->meanings[0]->meaning}}</p>
            </md-card>
        @endforeach
    </div>

    <h2>{{__('Vocabulary')}} - {{$vocabulary->count()}}</h2>
    <div class="row mb-3">
        @foreach($vocabulary as $vocab)
            <md-card class="mb-4 col-md-2 col-sm-4 col-6 vocab_learning_path_view_item" md-with-hover>
                <p class="word_title">{{$vocab->word}}</p>
                <p class="word_meaning">{{$vocab->meanings[0]->meaning}}</p>
            </md-card>
        @endforeach
    </div>
@endsection
