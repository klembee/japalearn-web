@extends('layouts.theApp')
@section('title')
    {{__('Edit grammar lesson')}}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

@section('content')
    <div>
        <edit-grammar-item
            :item-prop="{{json_encode($item)}}"
            save-endpoint="{{route('api.learning_path.grammar.admin.update', $item)}}"
            delete-question-endpoint="{{route('api.learning_path.grammar.admin.question.delete')}}"
        ></edit-grammar-item>
    </div>
@endsection
