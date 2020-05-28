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
                <div class="col-12">
                    <h2>Next video lessons</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>{{__('Student')}}</td>
                                <td>{{__('Date')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commingLessons as $lesson)
                            <tr>
                                <td>{{$lesson->studentInfo->user->name}}</td>
                                <td>{{$lesson->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h2>Lessons to confirm</h2>
                    <lessons-to-confirm-table
                        confirm-lesson-endpoint="{{route('api.video_lesson.confirm', ['lesson' => ':appointment_id'])}}"
                        :unconfirmed-lessons="{{json_encode($unconfirmedLessons)}}"
                    >

                    </lessons-to-confirm-table>
                </div>
            </div>

            <div>
                <h2>{{__('Configuration')}}</h2>
                <form method="post" action="{{route('video_lesson.updateInfo')}}"> <!-- Todo: Save -->
                    @csrf
                    <md-field>
                        <label>{{__('Pricing per hour of lesson')}}</label>
                        <md-input type="number" step="0.01" min="0" name="pricing_hour" :value="{{Auth::user()->info->video_lesson_price_hour / 100}}"></md-input>
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
