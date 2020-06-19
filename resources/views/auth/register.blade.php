@extends('layouts.notLoggedIn')

@section('seo_info')
    <title>JapaLearn - Create free account</title>
@endsection

<script>
    function fireRegisterEvent() {
        ga('send', 'event', 'register', 'button_click', 'registered', 1, {
            hitCallback: function(){
                var form = document.getElementById("register-form")
                if(form.reportValidity()) {
                    form.submit();
                }
            }
        });
    }
</script>

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
{{--                <div class="card-header">{{ __('Register') }}</div>--}}

                <div class="card-body">
                    <h1>Create your free account today</h1>
                    <p>Already have an account ? <a href="{{route('login')}}">Login</a></p>

                    <div class="mb-2">
                        <h2>How will JapaLearn help you ?</h2>
                        <div class="row m-0 ">
                            <div class="col-12 col-md-4">
                                <div class="how-help-card">
                                    <p class="how-help-number">92</p>
                                    <p class="how-help-text">Japanese kanas</p>
                                </div>

                            </div>
                            <div class="col-12 col-md-4">
                                <div class="how-help-card">
                                    <p class="how-help-number">2500</p>
                                    <p class="how-help-text">Most used kanjis</p>
                                </div>

                            </div>
                            <div class="col-12 col-md-4">
                                <div class="how-help-card">
                                    <p class="how-help-number">Many</p>
                                    <p class="how-help-text">Grammar lesson</p>
                                </div>

                            </div>
                        </div>
                        <p>With JapaLearn, you will learn all the Japanese kanas and the most used kanjis through a spaced repetition system. This system will allow you to maximize your memorization potential by making you review the items at the right moment.</p>
                    </div>
                    <hr />


                    <form method="POST" action="{{ route('register') }}" id="register-form">
                        @csrf

{{--                        <p>{{__('Do you want to learn japanese or teach it ?')}}</p>--}}
{{--                        <div class="row text-center mb-4">--}}
{{--                            <div class="col-6 p-0">--}}
{{--                                <md-card >--}}
{{--                                    <md-card-content>--}}

{{--                                        <div>--}}
{{--                                            <label for="student">--}}
{{--                                                <md-icon class="md-size-4x">sentiment_satisfied_alt</md-icon>--}}
{{--                                                <h2>Student</h2>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}

{{--                                        <input id="student" type="radio" name="account_type" value="student" checked/>--}}
{{--                                    </md-card-content>--}}
{{--                                </md-card>--}}
{{--                            </div>--}}
{{--                            <div class="col-6 p-0">--}}
{{--                                <md-card>--}}
{{--                                    <md-card-content>--}}
{{--                                        <div>--}}
{{--                                            <label for="teacher">--}}
{{--                                                <md-icon class="md-size-4x">supervisor_account</md-icon>--}}
{{--                                                <h2>Teacher</h2>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}

{{--                                        <input id="teacher" type="radio" name="account_type" value="teacher"/>--}}
{{--                                    </md-card-content>--}}
{{--                                </md-card>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <p>We need some information to setup your free account !</p>

                        <div class="mb-5">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            @include('part.countryInput')
                        </div>

                        <!-- TODO: Ne pas afficher si selectionné prof -->
                        <div>
                            <h2>{{__('Personalize your experience')}}</h2>
                            <p>Please tell us about your knowledge of the Japanese language so we can personalize your experince.</p>
                            <div>
                                <label for="kanas">Do you know the Japanese kanas ?</label>
                                <select id="kanas" name="experience_kana" class="form-control">
                                    <option value="no_knowlege">{{__('What are kanas?')}}</option>
                                    <option value="full_knowledge">{{__('I know katakanas and hiraganas')}}</option>
                                    <option value="hiragana_knowledge">{{__('I know hiraganas')}}</option>
                                    <option value="katakana_knowledge">{{__('I know katakanas')}}</option>
                                </select>
                            </div>

                            <div>
                                <label for="concentration">What do you want to concentrate your efforts on ?</label>
                                <select id="concentration" name="concentration" class="form-control">
                                    <option value="everything">A little bit of everything</option>
                                    <option value="kanjis">Kanjis/Vocabulary</option>
                                    <option value="speaking">Speaking</option>
                                    <option value="reading">Reading</option>
                                </select>

                            </div>

                            <div>
                                <label for="other_platform">Have you used another platform to learn Japanese before ?</label>
                                <select id="other_platform" name="experience_other_platform" class="form-control">
                                    <option value="no">{{__('No')}}</option>
                                    <option value="yes">{{__('Yes')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div>
                                <md-button type="submit" class="md-accent md-raised"
                                           onclick="event.preventDefault();fireRegisterEvent()"
                                    >
                                    {{ __('Register') }}
                                </md-button>
                                <p>By creating an account, you accept our <a href="{{route('frontpage.privacyPolicy')}}">privacy policy</a> and <a href="{{route('frontpage.termsAndConditions')}}">terms and conditions</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
