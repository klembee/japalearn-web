@extends('layouts.theApp')
@section('title')
    {{__('Edit level')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('kanji_learning_path.vocab.index')}}">{{__('Back')}}</md-button>
@endsection

@section('content')
    <h2>{{__('Radicals')}} - {{$radicals->count()}}</h2>
    <div class="row mb-3">
        @foreach($radicals as $radical)
            <learning-path-item-card
                update-endpoint="{{route('api.kanji_learning_path.items.update', ['item' => $radical->id])}}"
                delete-endpoint="{{route('api.kanji_learning_path.items.delete', ['item' => $radical->id])}}"
                :item-prop="{{json_encode($radical)}}"
            ></learning-path-item-card>
        @endforeach
    </div>

    <h2>{{__('Kanjis')}} - {{$kanjis->count()}}</h2>
    <div class="row mb-3">
        @foreach($kanjis as $kanji)
            <learning-path-item-card
                update-endpoint="{{route('api.kanji_learning_path.items.update', ['item' => $kanji->id])}}"
                delete-endpoint="{{route('api.kanji_learning_path.items.delete', ['item' => $kanji->id])}}"
                :item-prop="{{json_encode($kanji)}}"
            ></learning-path-item-card>
        @endforeach
    </div>

    <h2>{{__('Vocabulary')}} - {{$vocabulary->count()}}</h2>
    <div class="row mb-3">
        @foreach($vocabulary as $vocab)
            <learning-path-item-card
                update-endpoint="{{route('api.kanji_learning_path.items.update', ['item' => $vocab->id])}}"
                delete-endpoint="{{route('api.kanji_learning_path.items.delete', ['item' => $vocab->id])}}"
                :item-prop="{{json_encode($vocab)}}"
            ></learning-path-item-card>
        @endforeach
    </div>
@endsection
