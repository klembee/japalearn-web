@extends('layouts.theApp')
@section('title')
    {{__('User') . " " . $user->name}}
@endsection

@section('seo')
    <title>View user</title>
@endsection

@section('content')
    @if($user->isStudent())
    <div>
        <div>
            <h1>Kanjis</h1>
            <p>Level: {{$kanjiLevel}}</p>
            <p>Last review: {{$lastKanjiReviewDate}}</p>
        </div>
        <hr />
        <div>
            <h1>Kanas</h1>
            <p>Completed {{$nbKanaLevel5}} / {{\App\Models\Kana::query()->count()}} </p>
            <p>Last review: {{$lastKanaReviewDate}}</p>
        </div>
        <hr />
        <div>
            <h1>Grammar items</h1>
            <p>Completed {{$nbGrammarItemCompleted}}/{{\App\Models\GrammarLearningPathItem::query()->count()}}</p>
            <p>Last completed date: {{$grammarLastCompletedDate}}</p>
        </div>
    </div>
    @endif

@endsection
