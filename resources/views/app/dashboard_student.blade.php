@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-md-7 row mb-3">
                <md-card class="col-md-5">
                    <md-card-header>
                        <h3>{{__('Lessons')}}</h3>
                    </md-card-header>
                    <md-card-content>
                        <p>{{$user->userInfo->number_lessons}}</p>
                    </md-card-content>
                    <md-card-actions>
                        <md-button href="{{route('study.lesson')}}">{{__('Learn')}}</md-button>
                    </md-card-actions>
                </md-card>

                <md-card class="col-md-5">
                    <md-card-header>
                        <h3>{{__('Reviews')}}</h3>
                    </md-card-header>
                    <md-card-content>
                        <p>{{$user->userInfo->number_reviews}}</p>
                    </md-card-content>
                    <md-card-actions>
                        <md-button href="{{route('study.review')}}">{{__('Study')}}</md-button>
                    </md-card-actions>
                </md-card>
            </div>
            <div class="col-12">
                <h3>Number of level up per day this month</h3>
            </div>
        </div>
    </div>
@endsection
