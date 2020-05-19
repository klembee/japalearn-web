@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">
    <title>Grammar: {{$item->title}}</title>
    <meta name="description" content="{{$item->meta_description}}">
@endsection

@section('content')
    <div class="mt-4">
        <div>
            <view-grammar-item
                :item="{{json_encode($item)}}"
            ></view-grammar-item>

        </div>
    </div>
@endsection

