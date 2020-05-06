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
                <p>{{count($itemsToLearn)}}</p>
            </md-card-content>
            <md-card-actions>
                <md-button href="{{route('study.kana.lesson')}}">{{__('Learn')}}</md-button>
            </md-card-actions>
        </md-card>
        <md-card class="col-md-3 col-12">
            <md-card-header>
                <h1>{{__('Items to review')}}</h1>
            </md-card-header>
            <md-card-content>
                <p>{{count($itemsToReview)}}</p>
            </md-card-content>
            <md-card-actions>
                <md-button href="{{route('study.kana.review')}}">{{__('Review')}}</md-button>
            </md-card-actions>
        </md-card>
    </div>
    <hr />


    <p>The Japanese language consists of two scripts known as "kanas". The first one is the hiraganas.
        These are mainly used for grammatical purposes. The second one is the katakanas.
        These are mainly used to represent words imported from other countries.</p>

    <div class="row">
        <div class="col-xl-6 col-12">
            <h2>Hiragana</h2>
            <hiragana-table></hiragana-table>
        </div>
        <div class="col-xl-6 col-12">
            <h2>Katakana</h2>
            <katakana-table></katakana-table>
        </div>
    </div>

@endsection
