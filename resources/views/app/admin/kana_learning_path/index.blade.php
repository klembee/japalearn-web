@extends('layouts.theApp')
@section('title')
    {{__('Kana learning path')}}
@endsection

@section('toolbar_right')
@endsection

@section('content')
    <div>
        <div class="row">
            @foreach($kanas as $kana)
                <md-card class="col-md-2 mb-3">
                    <md-card-header>
                        <h2>{{$kana->kana}}</h2>
                    </md-card-header>
                    <md-card-content>
                        <p>{{$kana->mnemonic}}</p>
                    </md-card-content>
                    <md-card-actions>
                        <edit-kana-modal
                            save-endpoint="{{route('api.learning_path.kana.admin.update', $kana)}}"
                            :kana-prop="{{json_encode($kana)}}"
                        ></edit-kana-modal>
                    </md-card-actions>

                </md-card>
            @endforeach
        </div>

    </div>
@endsection
