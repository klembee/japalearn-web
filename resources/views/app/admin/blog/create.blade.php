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
        <create-article-form
            save-endpoint="{{route('api.blog.save')}}"
            view-article-url="{{route('frontpage.blog.view', ['post' => ':id'])}}"
        ></create-article-form>
    </div>
@endsection
