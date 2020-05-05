@extends('layouts.theApp')
@section('title')
    {{__('Kanji and vocabulary')}}
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-md-7 row mb-3">
                <md-card class="col-md-5">
                    <md-card-header>
                        <h3>{{__('Lessons')}}</h3>
                    </md-card-header>
                    <md-card-content>
                        <p>{{count($itemsToLearn)}}</p>
                    </md-card-content>
                    <md-card-actions>
                        <md-button href="{{route('study.vocab.lesson')}}">{{__('Learn')}}</md-button>
                    </md-card-actions>
                </md-card>

                <md-card class="col-md-5">
                    <md-card-header>
                        <h3>{{__('Reviews')}}</h3>
                    </md-card-header>
                    <md-card-content>
                        <p>{{count($itemsToReview)}}</p>
                    </md-card-content>
                    <md-card-actions>
                        <md-button href="{{route('study.vocab.review')}}">{{__('Study')}}</md-button>
                    </md-card-actions>
                </md-card>
            </div>

        </div>
{{--        <div class="row mb-4">--}}
{{--            @foreach($user->info->information->itemsPerHumanLevel() as $humanLevel => $nbItems)--}}
{{--                <md-card class="md-2">--}}
{{--                    <md-card-header>--}}
{{--                        <h3>{{$humanLevel}}</h3>--}}
{{--                        <p>{{$nbItems}}</p>--}}
{{--                    </md-card-header>--}}
{{--                </md-card>--}}
{{--            @endforeach--}}
{{--        </div>--}}
        <div>
            <vocab-size-per-day-graph
                data-endpoint="{{route('api.dashboard.vocab_size')}}"
            ></vocab-size-per-day-graph>
        </div>
    </div>
@endsection
