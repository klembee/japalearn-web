@extends('layouts.theApp')
@section('title')
    {{__('Learn hiragana and katakana')}}
@endsection

@section('toolbar_right')
    <md-button>{{__('Start learning !')}}</md-button>
@endsection

@section('content')
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
