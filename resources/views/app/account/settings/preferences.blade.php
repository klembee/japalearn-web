@extends('layouts.theApp')
@section('title')
    {{__('Preferences')}}
@endsection

@section('seo')
    <title>Settings - preferences</title>
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')

    <form method="POST" action="{{route('account.preferences.update')}}">
        @csrf
        <md-field>
            <label for="locale">Language</label>
            <md-select name="locale" id="locale">
                <md-option value="en">{{__('English')}}</md-option>
                <md-option value="fr">{{__('French')}}</md-option>
            </md-select>
        </md-field>

        <md-button type="submit" class="md-primary md-raised">{{__('Update')}}</md-button>
    </form>
@endsection
