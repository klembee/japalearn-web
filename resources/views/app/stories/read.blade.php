@extends('layouts.theApp')
@section('title')
    {{$story->title}}
@endsection

@section('content')
    <div>
        {!! $parsedContent !!}
    </div>
@endsection
