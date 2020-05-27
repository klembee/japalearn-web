@component('mail::message')
# {{$name}} contacted you on JapaLearn !

@component('mail::panel')
{{$message}}
@endcomponent

Email: {{$email}}
@endcomponent
