@extends('layouts.theApp')
@section('title')
    {{__('Gifts')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('admin.gifts.create')}}">New gift</md-button>
@endsection

@section('content')
    @foreach($gifts as $gift)
        <div>
            <h2>{{$gift->title}}</h2>
            <md-button href="{{route('admin.gifts.edit', $gift)}}">Edit</md-button>
        </div>
    @endforeach
@endsection
