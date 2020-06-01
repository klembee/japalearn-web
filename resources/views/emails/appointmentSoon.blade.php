@component('mail::message')
# You have an appointment in 15 minutes.

This is a friendly reminder that your have a video lesson starting soon.

{{-- TODO --}}
{{--@component('mail::button', ['url' => route('conference.join', ['appointment' => $meeting])])--}}
{{--Join meeting--}}
{{--@endcomponent--}}

@endcomponent
