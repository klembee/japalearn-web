@extends('layouts.theApp')
@section('title')
    {{__($item->title)}}
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

        <view-grammar-item
            :item="{{json_encode($item)}}"
            back-url="{{route('grammar.index')}}"
            practice-url="{{route('study.grammar.review', $item)}}"
        ></view-grammar-item>

    </div>
@endsection
