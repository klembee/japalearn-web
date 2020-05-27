@component('mail::message')
# {{$student->name}} wants a video lesson !

@component('mail::panel')
Date: {{$appointment->date->format("Y-m-d")}}

Hour: {{$appointment->date->format('H:i')}}
@endcomponent

Do you want to accept this opportunity?

@component('mail::button', ['url' => route('video_lesson.confirm', $appointment)])
Accept
@endcomponent

@component('mail::button', ['url' => route('video_lesson.refuse', $appointment)])
Refuse
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
