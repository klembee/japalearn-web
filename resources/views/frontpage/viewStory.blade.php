@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="{{env('APP_URL')}}/storage/{{$story->front_image_url}}">
    <title>{{$story->title}}</title>
    <meta name="description" content="{{$story->meta_description}}">
@endsection

@section('content')
    <div class="mt-4">
        <div>
            <story-reader
                :story="{{json_encode($story)}}"
            ></story-reader>

        </div>
    </div>
@endsection

