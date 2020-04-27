@extends('layouts.theApp')
@section('title')
    {{__('Category')}}: {{$category->category}}
@endsection

@section('toolbar_right')

    <add-grammar-item-modal
        save-api-endpoint="{{route('api.learning_path.grammar.store')}}"
        :category-id="{{$category->id}}"
    ></add-grammar-item-modal>
@endsection

@section('content')
    <div>
        @if($items->count() == 0)
            <p>{{__('No items in this category. Add one !')}}</p>
        @else
            <div class="row">
                @foreach($items as $item)
                    <md-card class="col-md-4">
                        <md-card-header>
                            <h3>{{$item->title}}</h3>
                        </md-card-header>
                        <md-card-content>
                            {{substr($item->content, 0, 20)}}...
                        </md-card-content>
                    </md-card>
                @endforeach
            </div>
        @endif

    </div>
@endsection
