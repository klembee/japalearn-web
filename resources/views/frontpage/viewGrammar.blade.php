@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">
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
                    <view-grammar-item
                        :item="{{json_encode($item)}}"
                        back-url="{{route('frontpage.grammar')}}"
                    ></view-grammar-item>
                </div>
            </div>


        </div>
    </div>
@endsection

