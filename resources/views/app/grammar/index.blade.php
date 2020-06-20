@extends('layouts.theApp')
@section('title')
    {{__('Learn grammar')}}
@endsection

@section('seo')
    <title>Learn grammar</title>
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

        <div class="row m-0">
            <div class="col-12 col-md-8">
                @if($nextItem)
                    <view-grammar-item
                        :item="{{json_encode($nextItem)}}"
                        mark-as-done-url="{{route('api.learning_path.grammar.update-level')}}"
                        practice-url="{{route('study.grammar.review', $nextItem)}}"
                        :logged-in="{{Auth::user() != null ? 'true' : 'false'}}"
                    ></view-grammar-item>

{{--                    <div>--}}
{{--                        <h3>{{__('Continue where you left')}}: <b>{{$nextItem->title}}</b></h3>--}}
{{--                        <p>{{substr($nextItem->content, 0, 20)}}...</p>--}}
{{--                        <md-button href="{{route('grammar.learn', $nextItem)}}" class="md-primary md-raised">Continue learning</md-button>--}}
{{--                    </div>--}}
                @endif
            </div>
            <div class="col-12 col-md-4 order-first order-md-last">
                @if($currentCategory)
                    <h2>Grammar lessons in {{$currentCategory->category}}</h2>
                    @foreach($currentCategory->items as $item)
                        <md-card class="mt-3">
                            <md-card-header>
                                <h3>{{$item->title}}</h3>
                            </md-card-header>
                            <md-card-content>
                                <p>{{$item->abstract}}</p>
                            </md-card-content>
                            <md-card-actions>
                                <md-button href="{{route('grammar.learn', $item)}}" class="md-raised md-accent">Read</md-button>
                            </md-card-actions>
                        </md-card>
                    @endforeach
                @else
                    <p>Congratulations ! You did all the grammar lessons.</p>
                @endif
            </div>
        </div>

    </div>
@endsection
