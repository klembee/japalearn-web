@extends('layouts.theApp')
@section('title')
    {{__('New story')}}
@endsection

@section('toolbar_right')

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

@section('content')
    <create-story-form
        :story-prop="{{json_encode($story)}}"
        save-endpoint="{{route('api.learning_path.stories.admin.createupdate')}}"
    ></create-story-form>
@endsection
