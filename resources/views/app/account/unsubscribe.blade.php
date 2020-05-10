@extends('layouts.theApp')
@section('title')
    {{__('Unsubscribing')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    <unsubscription-form
        cancel-url="{{route('dashboard')}}"
        unsubscribe-endpoint="{{route('api.payment.unsubscribe')}}"
    >

    </unsubscription-form>
@endsection
