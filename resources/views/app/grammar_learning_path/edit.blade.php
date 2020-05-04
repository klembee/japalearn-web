@extends('layouts.theApp')
@section('title')
    {{__('Edit grammar lesson')}}
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <div>
        <edit-grammar-item
            :item-prop="{{json_encode($item)}}"
            save-endpoint="{{route('api.learning_path.grammar.update', $item)}}"
            delete-question-endpoint="{{route('api.learning_path.grammar.question.delete')}}"
        ></edit-grammar-item>
    </div>
@endsection
