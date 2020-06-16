@extends('layouts.theApp')
@section('title')
    {{__('Video lessons')}}
@endsection

@section('seo')
    <title>Video lessons</title>
@endsection

@section('toolbar_right')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div>
                <h2>{{__('Configuration')}}</h2>
                <form method="post" action="{{route('video_lesson.updateInfo')}}"> <!-- Todo: Save -->
                    @csrf
                    <md-field>
                        <label>{{__('Pricing per hour of lesson')}}</label>
                        <md-input type="number" step="0.01" min="0" name="pricing_hour" :value="{{Auth::user()->info->video_lesson_price_hour / 100}}"></md-input>
                    </md-field>

                    <md-field>
                        <label>{{__('Description')}}</label>
                        <md-textarea name="description" value="{{Auth::user()->info->description ? Auth::user()->info->description : ""}}">

                        </md-textarea>
                    </md-field>

                    <div>
                        <label>Offer a 30 minute free trial</label>
                        <input type="checkbox" name="offer_free_trial" id="offer_free_trial" :checked="{{Auth::user()->info->offer_free_trial ? 'true' : 'false'}}"/>
                    </div>


                    <md-button type="submit" class="md-raised md-primary">{{__("Save")}}</md-button>
                </form>

            </div>

        </div>
        <div class="col-md-8 col-xs-12">
            <availability_selector
                save-availability-endpoint="{{route('api.video_lesson.updateAvailability')}}"
                fetch-availability-endpoint="{{route('api.video_lesson.fetchAvailability')}}"
            ></availability_selector>
        </div>
    </div>


@endsection
