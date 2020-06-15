@extends('layouts.theApp')
@section('title')
    {{__('Thank you !')}}
@endsection

@section('seo')
    <title>Thank you from JapaLearn !</title>
@endsection


@section('content')
    <div class="container">
        <h2>Thank you !</h2>
        <p>You did the first step toward the journey of learning the Japanese language !</p>
        <p>I hope that JapaLearn will live up to your expectations and help you toward your goal.</p>
        <br/>
        <p>If you have any questions or ideas to make JapaLearn better don't hesitate to contact us at <b>info@japalearn.com</b></p>
        <p>- Clement</p>

        <md-button href="{{route('dashboard')}}" class="md-raised md-accent">Start learning</md-button>
    </div>
@endsection
