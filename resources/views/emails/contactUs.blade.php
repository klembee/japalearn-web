@component('mail::panel')
# {{$name}} contacted you on JapaLearn !
@endcomponent

@component('mail::panel')
> {{$message}}

Email: {{$email}}
@endcomponent
