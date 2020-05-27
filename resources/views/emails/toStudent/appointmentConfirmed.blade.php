@component('mail::message')
# Your scheduled lesson was confirmed by {{$teacher->name}}

See you on {{$appointment->date->format("Y-m-d")}} at {{$appointment->date->format("h:i")}}  !
@endcomponent
