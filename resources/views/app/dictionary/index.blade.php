@extends('layouts.theApp')
@section('title')
    {{__('Dictionary')}}
@endsection

@section('seo')
    <title>JapaLearn - dictionary</title>
@endsection

@section('content')
    <div class="row m-0">
        <div class="col-12 col-md-8">
            <dictionary
                query-api-endpoint="{{route('api.dictionary.query')}}"
                vocabulary-add-api-endpoint="{{route('api.vocabulary.add')}}"
                :user-vocabulary-prop="{{$vocabularies}}"
                :is-student="{{$isStudent == 1 ? 'true' : 'false'}}"
            ></dictionary>
        </div>
        <div class="col-12 col-md-4">
            <h2>Saved vocabulary</h2>
            <md-table>
                <md-table-row>
                    <md-table-head>{{__('Word')}}</md-table-head>
                    <md-table-head>{{__('Level')}}</md-table-head>
                    <md-table-head>{{__('Last studied')}}</md-table-head>
                </md-table-row>
                @foreach($paginatedVocab as $vocabulary)
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
                {{$paginatedVocab->links()}}
            </div>
        </div>
    </div>
@endsection
