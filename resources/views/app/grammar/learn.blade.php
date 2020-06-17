@extends('layouts.theApp')
@section('title')
    {{__($item->title)}}
@endsection

@section('seo')
    <title>Grammar study</title>
@endsection

@section('content')
    <div>
{{--        <div class="grammar-item-content">--}}
{{--            <div>{!! $parsedContent !!}</div>--}}

{{--            <hr />--}}
{{--            @if($item->questions->count() > 0)--}}
{{--                <md-button href="{{route('study.grammar.review', $item)}}" class="md-primary md-raised">{{__('Practice')}}</md-button>--}}
{{--            @endif--}}
{{--        </div>--}}

        <md-button href="{{route('grammar.index')}}" class="md-raised md-accent back-button">Back to lesson list</md-button>
        <view-grammar-item
            mark-as-done-url="{{route('api.learning_path.grammar.update-level')}}"
            :item="{{json_encode($item)}}"
            practice-url="{{route('study.grammar.review', $item)}}"
        ></view-grammar-item>

    </div>
@endsection
