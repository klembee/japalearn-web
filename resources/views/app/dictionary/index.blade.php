@extends('layouts.theApp')
@section('title')
    {{__('Dictionary')}}
@endsection

@section('content')
    <dictionary
        query-api-endpoint="{{route('api.dictionary.query')}}"
        vocabulary-add-api-endpoint="{{route('api.vocabulary.add')}}"
        :user-vocabulary-prop="{{$vocabularies}}"
        :is-student="{{$isStudent == 1 ? 'true' : 'false'}}"
    ></dictionary>
@endsection
