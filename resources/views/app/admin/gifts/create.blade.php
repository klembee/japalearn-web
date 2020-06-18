@extends('layouts.theApp')
@section('title')
    {{__('Create gift')}}
@endsection

@section('content')
    <form method="post" action="{{route('admin.gifts.store')}}">
        @csrf
        <md-field>
            <label for="title">Title</label>
            <md-input id="title" name="title" required/>
        </md-field>

        <md-field>
            <label for="description">Description</label>
            <md-input id="description" name="description"/>
        </md-field>

        <md-field>
            <label for="image">Image url</label>
            <md-input id="image" name="image"/>
        </md-field>

        <h3>Files</h3>
        <md-field>
            <label for="gift1">Gift file</label>
            <md-input id="gift1" name="gift1"/>
        </md-field>
        <md-field>
            <label for="gift2">Gift file 2</label>
            <md-input id="gift2" name="gift2"/>
        </md-field>
        <md-field>
            <label for="gift3">Gift file 3</label>
            <md-input id="gift3" name="gift3"/>
        </md-field>

        <md-button type="submit" class="md-raised md-primary">Create</md-button>
    </form>
@endsection
