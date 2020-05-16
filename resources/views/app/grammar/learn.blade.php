@extends('layouts.theApp')
@section('title')
    {{__($item->title)}}
@endsection

@section('content')
    <div>
        <div class="grammar-item-content">
            <div>{!! $parsedContent !!}</div>

            <hr />
            @if($item->questions->count() > 0)
                <md-button href="{{route('study.grammar.review', $item)}}" class="md-primary md-raised">{{__('Practice')}}</md-button>
            @endif
        </div>

    </div>
@endsection
