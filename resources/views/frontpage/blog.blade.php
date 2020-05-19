@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">
    <title>JapaLearn's blog</title>
@endsection

@section('content')
    <div class="mt-4">
        <blog-list
            :paginated-posts="{{json_encode($posts)}}"
            view-post-url="{{route('frontpage.blog.view', ['post' => ":id"])}}"
        >
        </blog-list>
        {{$posts->links()}}
    </div>
@endsection
