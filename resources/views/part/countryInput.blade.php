<div class="form-group row">
    <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

    <div class="col-md-6">
{{--        <input id="country" type="text" class="form-control" name="country" required>--}}
        <select id="country" name="country" class="form-control">
            @foreach(\App\Models\Country::all() as $country)
                <option value="{{$country->code}}" @if($country->code == 'CA') selected @endif >{{$country->name}}</option>
            @endforeach
        </select>
    </div>
</div>
