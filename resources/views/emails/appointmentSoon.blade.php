@component('mail::message')
# You have an appointment in 15 minutes.

This is a friendly reminder that your have a video lesson starting soon.

@component('mail::button', ['url' => route('conference.join', ['meeting' => $meeting])])
Join meeting
@endcomponent

@endcomponent
