@extends('layouts.theApp')
@section('title')
    {{$story->title}}
@endsection

@section('content')
    <div>
        <story-reader
            :story="{{json_encode($story)}}"
        ></story-reader>
    </div>
@endsection

