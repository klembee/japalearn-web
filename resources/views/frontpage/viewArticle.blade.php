@extends('layouts.notLoggedIn')

@section('content')
    <view-article
        :article="{{json_encode($post)}}"
    ></view-article>
@endsection
