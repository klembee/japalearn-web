@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('content')
    <div class="row w-100">

        @if(!$user->info->stripe_account_id)
            <div class="alert alert-danger col-12 mx-3 d-flex justify-content-between align-items-center">
                Before students can schedule lessons with you, you need to setup your stripe account.
                <md-button href="{{$user->info->getStripeCreateAccountUrl()}}" class="md-raised md-primary">Setup stripe</md-button>
            </div>
        @endif

        <div class="col-12 col-md-6">
            <h2>Lessons to confirm</h2>
            <lessons-to-confirm-table
                refuse-lesson-url="{{route('video_lesson.refuse', ['appointment' => ":appointment_id"])}}"
                confirm-lesson-url="{{route('video_lesson.confirm', ['appointment' => ":appointment_id"])}}"
                :unconfirmed-lessons="{{json_encode($unconfirmedLessons)}}"
            >

            </lessons-to-confirm-table>
        </div>

        <div class="col-12 col-md-6">
            <h2>Next video lessons</h2>
            @if(count($commingLessons) > 0)
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
                            <td>{{$lesson->date->format('F jS')}} at {{$lesson->date->format('h:i')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <md-empty-state
                    md-icon="video_call"
                    md-label="Coming lessons"
                    md-description="When you confirm a lesson, it will appear here.">
                </md-empty-state>
            @endif
        </div>
    </div>


@endsection
