@extends('layouts.notLoggedIn')

@section('seo_info')
    <title>JapaLearn - {{$post->title}}</title>

    <meta property="og:url"  content="{{route('frontpage.blog.view', $post)}}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{$post->title}}" />
    <meta property="og:image" content="{{$post->image_url}}" />

    <!-- amp -->
    <link rel="amphtml" href="{{route('frontpage.blog.view.amp', $post)}}">

    @if($post->meta_description)
        <meta name="description" content="{{$post->meta_description}}">
        <meta property="og:description" content="{{$post->meta_description}}" />
    @else
        <meta name="description" content="Come learn the Japanese language on our blog !">
    @endif
@endsection

@section('scripts')
    <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
    </style>
@endsection

@section('content')
    <view-article
        fetch-comments-endpoint="{{route('api.frontpage.article.fetch_comments', ['post' => $post])}}"
        :article="{{json_encode($post)}}"
        :other-articles="{{json_encode($otherArticles)}}"
        leave-comment-endpoint="{{route('api.frontpage.article.comment', ['post' => $post])}}"
    >
        <template v-slot:mailchimp>
            @include('part.newsletterSubscriptionForm')
        </template>
    </view-article>
@endsection
