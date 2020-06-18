@extends('layouts.theApp')
@section('title')
    {{__('Edit gift')}}
@endsection

@section('content')
    <form method="post" action="{{route('admin.gifts.update', $gift)}}" >
        @csrf
        <md-field>
            <label for="title">Title</label>
            <md-input id="title" name="title" required value="{{$gift->title}}"/>
        </md-field>

        <md-field>
            <label for="description">Description</label>
            <md-input id="description" name="description" @if($gift->description)value="{{$gift->description}}"@endif/>
        </md-field>

        <md-field>
            <label for="image">Image url</label>
            <md-input id="image" name="image" @if($gift->image_url)value="{{$gift->image_url}}"@endif/>
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

        <md-button type="submit" class="md-raised md-primary">Save</md-button>
    </form>
@endsection
