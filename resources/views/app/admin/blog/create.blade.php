@extends('layouts.theApp')
@section('title')
    {{__('New article')}}
@endsection

{{--@section('toolbar_right')--}}
{{--    <md-button href="{{route('blog.create')}}">New article</md-button>--}}
{{--@endsection--}}

@section('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

@section('content')
    <div>
        @if(isset($post))
            <create-article-form
                :post-prop="{{json_encode($post)}}"
                :authors="{{json_encode($authors)}}"
                save-endpoint="{{route('api.blog.save')}}"
                view-article-url="{{route('frontpage.blog.view', ['post' => ':id'])}}"
            ></create-article-form>
        @else
            <create-article-form
                save-endpoint="{{route('api.blog.save')}}"
                :authors="{{json_encode($authors)}}"
                view-article-url="{{route('frontpage.blog.view', ['post' => ':id'])}}"
            ></create-article-form>
        @endif

    </div>
@endsection
