@extends('layouts.theApp')
@section('title')
    {{__('Learn hiragana and katakana')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('study.kana.lesson')}}">{{__('Start learning !')}}</md-button>
@endsection

@section('content')

    <div class="row">
        <md-card class="col-md-3 col-12">
            <md-card-header>
                <h1>{{__('Items to learn')}}</h1>
            </md-card-header>
            <md-card-content>
                <p class="h3">{{count($itemsToLearn)}}</p>
            </md-card-content>
            <md-card-actions>
                @if(count($itemsToLearn) > 0)
                    <md-button href="{{route('study.kana.lesson')}}" class="md-raised md-accent">{{__('Learn')}}</md-button>
                @else
                    <md-button disabled class="md-raised md-accent">{{__('Learn')}}</md-button>
                @endif
            </md-card-actions>
        </md-card>
        <md-card class="col-md-3 col-12">
            <md-card-header>
                <h1>{{__('Items to review')}}</h1>
            </md-card-header>
            <md-card-content>
                <p class="h3">{{count($itemsToReview)}}</p>
            </md-card-content>
            <md-card-actions>
                @if(count($itemsToReview) > 0)
                    <md-button href="{{route('study.kana.review')}}" class="md-raised md-accent">{{__('Review')}}</md-button>
                @else
                    <md-button disabled class="md-raised md-accent">{{__('Review')}}</md-button>
                @endif
            </md-card-actions>
        </md-card>
    </div>
    <hr />


{{--    <p>The Japanese language consists of two scripts known as "kanas". The first one is the hiraganas.--}}
{{--        These are mainly used for grammatical purposes. The second one is the katakanas.--}}
{{--        These are mainly used to represent words imported from other countries.</p>--}}

    <div class="row">
        <div class="col-xl-6 col-12">
            <h2>Hiragana</h2>
            <hiragana-table
                :kanas="{{json_encode($allKanas)}}"
            ></hiragana-table>
        </div>
        <div class="col-xl-6 col-12">
            <h2>Katakana</h2>
            <hiragana-table
                :kanas="{{json_encode($allKanas)}}"
                :is-katakana="true"
            ></hiragana-table>
        </div>
    </div>

@endsection
