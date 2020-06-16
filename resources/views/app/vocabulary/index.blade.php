@extends('layouts.theApp')
@section('title')
    {{__('Your vocabulary')}}
@endsection

@section('seo')
    <title>Saved vocabulary</title>
@endsection

@section('content')
    <md-table>
        <md-table-row>
            <md-table-head>{{__('Word')}}</md-table-head>
            <md-table-head>{{__('Level')}}</md-table-head>
            <md-table-head>{{__('Last studied')}}</md-table-head>
        </md-table-row>
        @foreach($vocabularies as $vocabulary)
            <md-table-row>
                <md-table-cell>{{$vocabulary->word}}</md-table-cell>
                <md-table-cell>{{$vocabulary->pivot->level}}</md-table-cell>
                <md-table-cell>
                    @if($vocabulary->pivot->last_studied)
                        {{$vocabulary->pivot->last_studied}}
                    @else
                        {{__('Never')}}
                    @endif
                </md-table-cell>
            </md-table-row>
        @endforeach
    </md-table>

    <div class="mt-3 mx-auto" style="width:fit-content;">
        {{$vocabularies->links()}}
    </div>
@endsection
