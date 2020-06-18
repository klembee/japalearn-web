@component('mail::message')
# {{$name}} You received a gift from JapaLearn !

@if($gift->documents->count() > 0)
@component('mail::button', ['url' => $gift->documents[0]->document_path])
Download gift
@endcomponent
@endif
@endcomponent
