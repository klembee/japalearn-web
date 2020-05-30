@component('mail::message')
# Please tell us how was your lesson with {{$appointment->teacherInfo->user->name}}

Your opinion is important for us and {{$appointment->teacherInfo->user->name}}.

<a href="{{route('video_lesson.rate_appointment', $appointment)}}">
<img src="{{env('APP_URL')}}/images/emails/email-stars.jpg"/>
</a>

**Click** on the stars to rate your lesson.

Thank you.<br>
JapaLearn
@endcomponent

