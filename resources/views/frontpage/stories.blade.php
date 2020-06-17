@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">
    <title>Japanese short story</title>
    <meta name="description" content="Learn the Japanese language by reading original Japanese short stories !">
@endsection

@section('content')
    <div class="mt-4">
        @foreach($stories as $story)
            <story-list-item-card
                :story="{{json_encode($story)}}"
                read-url="{{route('frontpage.story.read', $story['slug'])}}"
            >

            </story-list-item-card>
        @endforeach

        <div class="row m-0">
            <div class="col-11 col-sm-10 col-md-8 col-lg-5 mx-auto">
                @if(Auth::user())
                    <p>Get access to more stories in your <a href="{{route('reading.index')}}">dashboard</a></p>
                @else
                    <p><a href="{{route('login')}}">Login</a> or <a href="{{route('register')}}">Register</a> to get access to more Japanese short stories !</p>
                @endif
            </div>
        </div>

    </div>

@endsection
