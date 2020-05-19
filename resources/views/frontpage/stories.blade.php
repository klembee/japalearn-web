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
                read-url="{{route('frontpage.story.read', $story)}}"
            >

            </story-list-item-card>
        @endforeach
    </div>

@endsection
