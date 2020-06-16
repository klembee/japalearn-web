@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">
    <title>JapaLearn's blog</title>
@endsection

@section('scripts')
    <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
    </style>
@endsection

@section('content')
    <div class="mt-4 page-content">
        <div class="row m-0">
            <div class="col-12 col-md-8 col-lg-9">
                <blog-list
                    :paginated-posts="{{json_encode($posts)}}"
                    view-post-url="{{route('frontpage.blog.view', ['post' => ":id"])}}"
                >
                </blog-list>
                {{$posts->links()}}
            </div>
            <div class="col-12 col-md-4 col-lg-3">
                @include('part.newsletterSubscriptionForm')
            </div>
        </div>

    </div>
@endsection
