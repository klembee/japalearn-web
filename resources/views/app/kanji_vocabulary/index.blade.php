@extends('layouts.theApp')
@section('title')
    {{__('Kanji and vocabulary')}}
@endsection

@if(!$userLearnedKanas)
    @section('alert')
        <div class="alert alert-danger" role="alert">
            It seems like you haven't learned all the kanas yet. It will be harder to learn the kanjis and vocabulary without this knowledge.
        </div>
    @endsection
@endif


@section('content')
    <div>
        <div class="row">
            <div class="col-md-7 mb-3">
                <div class="row">
                    <md-card class="col-md-5 nb-lessons-reviews-box" >
                        <md-card-header>
                            <h3>{{__('Lessons')}}</h3>
                        </md-card-header>
                        <md-card-content>
                            <p class="h3">{{count($itemsToLearn)}}</p>
                        </md-card-content>
                        <md-card-actions>
                            <md-button href="{{route('study.vocab.lesson')}}">{{__('Learn')}}</md-button>
                        </md-card-actions>
                    </md-card>

                    <md-card class="col-md-5 nb-lessons-reviews-box">
                        <md-card-header>
                            <h3>{{__('Reviews')}}</h3>
                        </md-card-header>
                        <md-card-content>
                            <p class="h3">{{count($itemsToReview)}}</p>
                        </md-card-content>
                        <md-card-actions>
                            <md-button href="{{route('study.vocab.review')}}">{{__('Study')}}</md-button>
                        </md-card-actions>
                    </md-card>
                </div>

                <div class="mt-3">
                    <vocab-size-per-day-graph
                        data-endpoint="{{route('api.dashboard.vocab_size')}}"
                    ></vocab-size-per-day-graph>
                </div>
            </div>
            <div class="col-sm-5 col-md-4 offset-md-1 col-xl-3 offset-xl-2">
                <h2>Reviews this week</h2>
                <review-forecast
                    :number-reviews-per-day="{{json_encode($nextWeekVocabReview)}}"
                >

                </review-forecast>
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
    </div>
@endsection
