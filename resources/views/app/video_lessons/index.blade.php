@extends('layouts.theApp')
@section('title')
    {{__('Video lessons')}}
@endsection

@section('toolbar_right')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="row">
                <div class="col-6">
                    <h2>Next video lessons</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>{{__('Student')}}</td>
                                <td>{{__('Date')}}</td>
                            </tr>
                        </thead>
                        <!-- Todo: Ajouter next lessons -->
                    </table>
                </div>
                <div class="col-6">
                    <h2>Lessons to confirm</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>{{__('Student')}}</td>
                                <td>{{__('Date')}}</td>
                                <td>{{__('Action')}}</td>
                            </tr>
                        </thead>
                        <!-- todo: Pouvoir accepter ou refuser des rendez-vous -->
                    </table>
                </div>
            </div>

            <div>
                <h2>{{__('Configuration')}}</h2>
                <form method="post" action="#"> <!-- Todo: Save -->
                    <md-field>
                        <label>{{__('Pricing per hour of lesson')}}</label>
                        <md-input type="number" step="0.01" min="0" :value="{{Auth::user()->studentInfo->video_lesson_price_hour / 100}}"></md-input>
                    </md-field>

                    <md-button type="submit" class="md-raised md-primary">{{__("Save")}}</md-button>
                </form>

            </div>

        </div>
        <div class="col-md-6 col-xs-12">
            <availability_selector
                save-availability-endpoint="{{route('api.video_lesson.updateAvailability')}}"
                fetch-availability-endpoint="{{route('api.video_lesson.fetchAvailability')}}"
            ></availability_selector>
        </div>
    </div>


@endsection
