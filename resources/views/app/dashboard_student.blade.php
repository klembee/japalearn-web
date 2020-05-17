@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div>
        <learning-journey
            :done-basic-kanas="{{$doneBasicKanas ? 'true' : 'false'}}"
            kana-url="{{route('kanas.index')}}"
        ></learning-journey>

        <div class="dashboard-content">
            <div class="row mt-4">
                <div class="col-6 h-fit">
                    <dictionary
                        query-api-endpoint="{{route('api.dictionary.query')}}"
                        vocabulary-add-api-endpoint="{{route('api.vocabulary.add')}}"
                        {{--                    :user-vocabulary-prop="{{$vocabularies}}"--}}
                        :is-student="{{Auth::user()->isStudent() == 1 ? 'true' : 'false'}}"
                    ></dictionary>
                </div>

                <md-content class="col-3 offset-2 md-elevation-3 h-fit">
                    <latest-activity-widget
                        latest-activity-api="{{route('api.dashboard.latest_activity')}}"
                    ></latest-activity-widget>
                </div>
            </div>
        </div>

    </div>
@endsection
