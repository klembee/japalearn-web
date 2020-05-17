@extends('layouts.theApp')
@section('title')
    {{__('Payment processing')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    @include('app.account.settings.part.nav')

    <md-content>
        @if(count($paymentMethods) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <td>Card</td>
                        <td>Expiration</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentMethods as $paymentMethod)

                        <tr>
                            <td>**** **** **** {{$paymentMethod->card->last4}}</td>
                            <td>{{$paymentMethod->card->exp_month}}/{{$paymentMethod->card->exp_year}}</td>
                            <td>
                                <delete-payment-method-button
                                    delete-endpoint="{{route('api.payment.delete-payment-method')}}"
                                    payment-id="{{$paymentMethod->id}}"
                                ></delete-payment-method-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- New Payment Method form -->
        <div class="row">
            <div class="col-6">
                <h3>New payment method</h3>
                <new-payment-method-form
                    user-email="{{Auth::user()->email}}"
                    save-method-endpoint="{{route('api.payment.add-payment-method')}}"
                    stripe-key="{{env('STRIPE_KEY')}}"
                    client-secret="{{$stripeIntent}}"
                ></new-payment-method-form>
            </div>
        </div>

    </md-content>
@endsection
