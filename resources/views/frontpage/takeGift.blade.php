@extends('layouts.notLoggedIn')

@section('seo_info')
    @if($gift->image_url)
    <meta property="og:image" content="{{$gift->image_url}}">
    @endif
    <title>JapaLearn gift - {{$gift->title}}</title>
    @if($gift->description)
    <meta name="description" content="{{$gift->description}}">
    @endif
@endsection

@section('content')

<div class="row m-0">
    <div class="col-md-6">
        @if($gift->image_url)
            <img src="{{$gift->image_url}}"/>
        @endif
    </div>
    <div class="col-md-4 offset-md-1">
        <div class="mt-4">
            <h1>{{$gift->title}}</h1>
            @if($gift->description)
                <p>{{$gift->description}}</p>
            @endif

            <h2>Please fill out this form to receive your free gift</h2>
            <form method="post" action="{{route('frontpage.sendGift', $gift)}}">
                @csrf
                <md-field>
                    <label for="email">Email</label>
                    <md-input name="email" id="email" type="email"/>
                </md-field>
                <md-field>
                    <label for="name">Name</label>
                    <md-input name="name" id="name"/>
                </md-field>
                <input type="checkbox" name="subscribe" id="subscribe" />
                <label for="subscribe">I want to subscribe to the newsletter</label> <br />
                <md-button type="submit" class="md-raised md-accent">Take gift</md-button>
            </form>
        </div>

    </div>
</div>
@endsection
