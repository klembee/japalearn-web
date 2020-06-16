@extends('layouts.theApp')
@section('title')
    {{__('Schedule a lesson with')}} {{$teacher->name}}
@endsection

@section('seo')
    <title>Schedule a lesson</title>
@endsection

@section('toolbar_right')

@endsection

@section('content')
    <schedule_form
        schedule-endpoint="{{route('api.video_lesson.schedule')}}"
        user-email="{{Auth::user()->email}}"
        save-payment-method-endpoint="{{route('api.payment.add-payment-method')}}"
        stripe-key="{{env('STRIPE_KEY')}}"
        client-secret="{{$stripeIntent}}"
        :credit-cards="{{json_encode($creditCards)}}"
        :teacher="{{json_encode($teacher)}}"
        available-times-endpoint="{{route('api.video_lesson.fetchAvailabilityDate')}}"
    ></schedule_form>
@endsection
