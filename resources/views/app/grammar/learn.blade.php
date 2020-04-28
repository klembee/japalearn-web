@extends('layouts.theApp')
@section('title')
    {{__($item->title)}}
@endsection

@section('content')
    <div>
        <div class="grammar-item-content">
            <p>{!! $parsedContent !!}</p>
        </div>

        <md-button href="#" class="md-primary md-raised">{{__('Go to exercises')}}</md-button>
    </div>
@endsection
