@extends('layouts.theApp')
@section('title')
    {{__('Learn grammar')}}
@endsection

@section('content')
    <div>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-3 text-center">
                    <h3 class="d-inline-block">{{__($category->category)}}</h3>
                    <p>{{$category->number_items_done}} / {{$category->number_items}}</p>
                </div>
            @endforeach
        </div>
        <hr />

        @if($nextItem)
            <div>
                <h3>{{__('Continue where you left')}}: <b>{{$nextItem->title}}</b></h3>
                <p>{{substr($nextItem->content, 0, 20)}}...</p>
                <md-button href="{{route('grammar.learn', $nextItem)}}" class="md-primary md-raised">Continue learning</md-button>
            </div>
        @endif
    </div>
@endsection
