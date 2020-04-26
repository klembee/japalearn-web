@extends('layouts.theApp')
@section('title')
    {{__('Grammar learning path')}}
@endsection

@section('toolbar_right')
    <md-button href="#">New category</md-button>
@endsection

@section('content')
    <div>
        <div class="row">
            @foreach($categories as $category)
                <md-card class="col-md-3 mb-3">
                    <md-card-header>
                        <h2>{{$category->category}}</h2>
                    </md-card-header>
                    <md-card-content>
                        <p>{{$category->number_items}} items</p>
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-primary md-raised">Add or edit items</md-button>
                    </md-card-actions>

                </md-card>
            @endforeach
        </div>

    </div>
@endsection
