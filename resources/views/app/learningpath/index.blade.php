@extends('layouts.theApp')
@section('title')
    {{__('Learning paths')}}
@endsection

@section('toolbar_right')
    <new-learningpath-item-modal
        create-api-endpoint="{{route('learningpath.items.store')}}"
    ></new-learningpath-item-modal>
@endsection

@section('content')

@endsection
