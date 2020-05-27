@component('mail::message')
# Your scheduled lesson on {{$lesson->date->format("Y-m-d")}} was refused by {{$teacher->name}}

You will be completely refunded.
@endcomponent
