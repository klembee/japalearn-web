@extends('layouts.theApp')
@section('title')
    {{__('Stories')}}
@endsection

@section('toolbar_right')
    <md-button href="{{route('learning_path.stories.create')}}">Create new</md-button>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
            <h1>Authors</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>bio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                        <tr>
                            <td>{{$author->id}}</td>
                            <td>
                                <md-avatar>
                                    <img src="/storage/{{$author->profile_picture_url}}"/>
                                </md-avatar>
                                {{$author->name}}
                            </td>
                            <td>{{$author->bio}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr />

            <create-author-form
                save-endpoint="{{route('api.learning_path.stories.admin.create_author')}}"
            ></create-author-form>
        </div>
    </div>

@endsection
