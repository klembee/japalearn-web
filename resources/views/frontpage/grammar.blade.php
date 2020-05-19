@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">
    <title>Japanese grammar lessons</title>
    <meta name="description" content="Learn the Japanese grammar with JapaLearn.">
@endsection

@section('content')

    <grammar-item-list
        :items="{{json_encode($items)}}"
        :categories="{{json_encode($categories)}}"
        :current-category-id="{{$currentCategoryId}}"
        goto-category-url="{{route('frontpage.grammar.category', ['category' => ':id'])}}"
        view-url="{{route('frontpage.grammar.view', ['item' => ':id'])}}"
    >
        {{$items->links()}}

    </grammar-item-list>
@endsection
