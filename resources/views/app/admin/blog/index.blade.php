@extends('layouts.theApp')
@section('title')
    {{__('Blog articles')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('blog.create')}}">New article</md-button>
@endsection

@section('content')
    <div>

    </div>
@endsection
