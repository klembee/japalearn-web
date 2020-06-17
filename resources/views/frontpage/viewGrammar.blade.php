@extends('layouts.notLoggedIn')

@section('seo_info')
    @if($item->front_image_url)
        <meta property="og:image" content="{{$item->front_image_url}}">
    @else
        <meta property="og:image" content="/images/facebook-share.jpg">
    @endif
    <title>Grammar: {{$item->title}}</title>
    @if($item->meta_description)
        <meta name="description" content="{{$item->meta_description}}">
    @endif
@endsection

@section('content')
    <div class="mt-4">
        <div>
            <div class="row w-100 m-0">
                <div class="col-lg-7 col-md-9 col-12 m-auto">
                    <md-button href="{{route('frontpage.grammar')}}" class="md-raised md-accent back-button">Back to lesson list</md-button>
                    <view-grammar-item
                        :item="{{json_encode($item)}}"
                    ></view-grammar-item>
                </div>
            </div>
        </div>
    </div>
@endsection

