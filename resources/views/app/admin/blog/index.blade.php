@extends('layouts.theApp')
@section('title')
    {{__('Blog articles')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('blog.create')}}">New article</md-button>
@endsection

@section('content')
    <div>
        <blog-list
            :paginated-posts="{{json_encode($posts)}}"
            edit-post-url="{{route('blog.edit', ['post' => ':id'])}}"
            view-post-url="{{route('frontpage.blog.view', ['post' => ":id"])}}"
        >
        </blog-list>
        {{$posts->links()}}
    </div>
@endsection
