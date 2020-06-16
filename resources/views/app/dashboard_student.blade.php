@extends('layouts.theApp')
@section('title')
    {{__('Your Dashboard')}}
@endsection

@section('seo')
    <title>JapaLearn - Dashboard</title>
@endsection

@section('content')
    <div>
        @if(Auth::user()->email_verified_at == null)
            <div class="alert alert-danger d-flex justify-content-between align-items-center">
                <p class="m-0">Please verify your email address.</p>

                <form method="POST" action="{{route('resend_confirmation')}}">
                    @csrf
                    <md-button type="submit" class="md-raised md-accent">Resend confirmation</md-button>
                </form>

            </div>
        @endif

{{--        <learning-journey--}}
{{--            :done-basic-kanas="{{$doneBasicKanas ? 'true' : 'false'}}"--}}
{{--            kana-url="{{route('kanas.index')}}"--}}
{{--        ></learning-journey>--}}

        <div class="dashboard-content">
            <div class="row mt-4">
                <div class="col-lg-7 col-12 h-fit mb-4 mb-md-0">
                    <dictionary
                        query-api-endpoint="{{route('api.dictionary.query')}}"
                        vocabulary-add-api-endpoint="{{route('api.vocabulary.add')}}"
                        {{--                    :user-vocabulary-prop="{{$vocabularies}}"--}}
                        :is-student="{{Auth::user()->isStudent() == 1 ? 'true' : 'false'}}"
                    ></dictionary>
                </div>

                <md-content class="col-12 col-lg-5 h-fit">

                    @if($nextAppointments->count() > 0)
                        <md-card class="mb-4">
                            <md-card-header>
                                <h2>Your scheduled lessons</h2>
                            </md-card-header>
                            <md-card-content>
                                <table class="table">
                                    <thead>
                                        <th>Teacher</th>
                                        <th>Date</th>
                                        <th></th>
                                    </thead>
                                    @foreach($nextAppointments as $appointment)
                                        <tr>
                                            <td>{{$appointment->teacherInfo->user->name}}</td>
                                            <td>{{$appointment->date->format('Y-m-d H:i')}}</td>
                                            <td>
                                                @if(!$appointment->ready_to_join)
                                                    <div>
                                                        <md-button disabled class="md-raised md-accent">Join lesson</md-button>
                                                        <md-tooltip md-direction="top">You can join the lesson 15 minutes before it starts</md-tooltip>
                                                    </div>
                                                @else
                                                    <div>
                                                        <md-button class="md-raised md-accent">Join lesson</md-button>
                                                    </div>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </md-card-content>
                        </md-card>

                    @endif

                    <!-- Get started -->
                    @if(!$user->info->did_all_first_steps)
                    <md-card class="get-started-card mb-3">
                        <md-card-header>
                            <h2>Get started</h2>
                        </md-card-header>
                        <md-card-content>
                            <a href="{{route('grammar.learn', \App\Models\GrammarLearningPathItem::query()->first())}}">
                                <div class="get-started-item clickable">
                                    <div>
                                        @if(!$user->info->tookFirstGrammarLesson())
                                            <md-icon>check_circle_outline</md-icon>
                                        @else
                                            <md-icon>check_circle</md-icon>
                                        @endif
                                    </div>
                                    <p>Take your first grammar lesson</p>
                                </div>
                            </a>

                            <a href="{{route('kanas.index')}}">
                                <div class="get-started-item clickable">
                                    <div>
                                        @if(!$user->info->learnedFirst10Kanas())
                                            <md-icon>check_circle_outline</md-icon>
                                        @else
                                            <md-icon>check_circle</md-icon>
                                        @endif
                                    </div>

                                    <p>Learn the first ten kanas</p>
                                </div>
                            </a>

                            <a href="{{route('kanji_vocabulary.index')}}">
                                <div class="get-started-item clickable">
                                    <div>
                                        @if(!$user->info->learnedFirstKanji())
                                            <md-icon>check_circle_outline</md-icon>
                                        @else
                                            <md-icon>check_circle</md-icon>
                                        @endif
                                    </div>

                                    <p>Learn your first kanji</p>
                                </div>
                            </a>

                            <a href="{{route('kanas.index')}}">
                                <div class="get-started-item clickable">
                                    <div>
                                        @if(!$user->info->didFirstKanaReview())
                                            <md-icon>check_circle_outline</md-icon>
                                        @else
                                            <md-icon>check_circle</md-icon>
                                        @endif
                                    </div>

                                    <p>Wait and do your kana reviews</p>
                                </div>
                            </a>

                            <a href="{{route('kanji_vocabulary.index')}}">
                                <div class="get-started-item clickable">
                                    <div>
                                        @if(!$user->info->didFirstKanjiReviews())
                                            <md-icon>check_circle_outline</md-icon>
                                        @else
                                            <md-icon>check_circle</md-icon>
                                        @endif
                                    </div>

                                    <p>Wait and do your kanji reviews</p>
                                </div>
                            </a>
                        </md-card-content>
                    </md-card>
                    @endif


                    <latest-activity-widget
                        latest-activity-api="{{route('api.dashboard.latest_activity')}}"
                        class="md-elevation-3 p-3"
                    ></latest-activity-widget>
                </div>
            </div>
        </div>

    </div>
@endsection
