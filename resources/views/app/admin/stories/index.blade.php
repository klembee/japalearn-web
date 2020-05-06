@extends('layouts.theApp')
@section('title')
    {{__('Stories')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('learning_path.stories.create')}}">Create new</md-button>
@endsection

@section('content')
    @foreach($stories as $story)
        <md-card>
            <md-card-header>
                <h1>{{$story->title}}</h1>
            </md-card-header>
            <md-card-content>
                <div>
                    {{substr($story->content, 0, 100)}}...
                </div>
            </md-card-content>
            <md-card-actions>
                <md-button href="{{route('learning_path.stories.edit', $story)}}">{{__('Edit')}}</md-button>
                <md-button href="{{route('learning_path.stories.delete', $story)}}">{{__('Delete')}}</md-button>
                <md-button href="{{route('stories.read', $story)}}" class="md-primary md-">{{__('Read more')}}</md-button>
            </md-card-actions>

        </md-card>
    @endforeach
@endsection
