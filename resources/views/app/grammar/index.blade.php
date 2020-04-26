@extends('layouts.theApp')
@section('title')
    {{__('Learn grammar')}}
@endsection

@section('content')
    <div>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-3 text-center">
                    <h3 class="d-inline-block">{{__($category->category)}}</h3>
                    <p>0 %</p>
                </div>
            @endforeach
        </div>
        <hr />

        <div>
            <h3>{{__('Continue where you left')}}: <b>は particle</b></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vitae augue sed odio sodales egestas. Quisque dictum tincidunt nibh, ut eleifend nibh lacinia id.</p>
            <md-button class="md-primary md-raised">Continue learning</md-button>
        </div>
    </div>
@endsection
