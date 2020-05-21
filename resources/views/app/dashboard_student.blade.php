@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div>
        @if(Auth::user()->email_verified_at == null)
            <div class="alert alert-danger d-flex justify-content-between align-items-center">
                <p class="m-0">Please verify your email address.</p>

                <form method="POST" action="{{route('resend_confirmation')}}">
                    @csrf
                    <md-button type="submit" class="md-raised md-accent">Resend confirmation</md-button>
                </form>

            </div>
        @endif

        <learning-journey
            :done-basic-kanas="{{$doneBasicKanas ? 'true' : 'false'}}"
            kana-url="{{route('kanas.index')}}"
        ></learning-journey>

        <div class="dashboard-content">
            <div class="row mt-4">
                <div class="col-lg-7 col-12 h-fit mb-4 mb-md-0">
                    <dictionary
                        query-api-endpoint="{{route('api.dictionary.query')}}"
                        vocabulary-add-api-endpoint="{{route('api.vocabulary.add')}}"
                        {{--                    :user-vocabulary-prop="{{$vocabularies}}"--}}
                        :is-student="{{Auth::user()->isStudent() == 1 ? 'true' : 'false'}}"
                    ></dictionary>
                </div>

                <md-content class="col-12 col-lg-5 h-fit">
                    <latest-activity-widget
                        latest-activity-api="{{route('api.dashboard.latest_activity')}}"
                        class="md-elevation-3 p-3"
                    ></latest-activity-widget>
                </div>
            </div>
        </div>

    </div>
@endsection
