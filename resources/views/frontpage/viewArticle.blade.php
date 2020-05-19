@extends('layouts.notLoggedIn')

@section('seo_info')
    <title>JapaLearn - {{$post->title}}</title>

    <meta property="og:url"  content="{{route('frontpage.blog.view', $post)}}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{$post->title}}" />
    <meta property="og:image" content="{{env('APP_URL')}}/storage/{{$post->image_url}}" />

    @if($post->meta_description)
        <meta name="description" content="{{$post->meta_description}}">
        <meta property="og:description" content="{{$post->meta_description}}" />
    @else
        <meta name="description" content="Come learn the Japanese language on our blog !">
    @endif
@endsection

@section('content')
    <view-article
        :article="{{json_encode($post)}}"
    ></view-article>
@endsection
