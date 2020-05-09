@if ($message = Session::get('success'))
    <flash
        type="success"
        message="{{$message}}"
    ></flash>
@endif


@if ($message = Session::get('error'))
    <flash
        type="error"
        message="{{$message}}"
    ></flash>
@endif
