@extends('layouts.theApp')
@section('title')
    {{__('Edit grammar lesson')}}
@endsection

@section('content')
    <div>
        <edit-grammar-item
            :item-prop="{{json_encode($item)}}"
            save-endpoint="{{route('api.learning_path.grammar.update', $item)}}"
        ></edit-grammar-item>
    </div>
@endsection
