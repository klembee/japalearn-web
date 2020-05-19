@extends('layouts.notLoggedIn')

@section('seo_info')
    <meta property="og:image" content="/images/facebook-share.jpg">

    <title>JapaLearn - Learn Japanese the right way !</title>
    <meta name="description" content="Learn the Japanese language with JapaLearn ! We propose a unique way to learn the Japanese language">
@endsection

@section('content')
    <div class="header-container">
        <div class="header">
            <div class="header-content">
                <h1>JapaLearn</h1>
                <p>Planning a trip to <b>Japan</b> or just interested in the <b>Japanese language</b>?</p>
                <md-button class="md-primary md-raised">Start learning</md-button>
            </div>

        </div>
    </div>

    <div class="section0 section">
        <div class="content">
            <div class="text">
                <h2>What is <b>JapaLearn</b></h2>
                <p><b>JapaLearn</b> is a platform that helps people <em>learn</em> the <b>Japanese language</b> using various methods.</p>
                <p>We propose grammar lessons, Japanese stories, tools that makes the learning of the kanjis and vocabulary a breeze and much more.</p>
            </div>
        </div>
    </div>

    <div class="section1 section">
        <div class="content">
            <div class="text">
                <h2>Learn Japanese the <b>JapaLearn</b> way</h2>
                <ul>
                    <li><p>No prior knowledge required</p></li>
                    <li><p>Learn by listening, reading and speaking.</p></li>
                    <li><p>Learn more than 2500 kanjis using spaced repetition.</p></li>
                    <li><p>Reading and grammar lessons</p></li>
                    <li><p>Real world examples</p></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="section2 section">
        <div class="content">
            <div class="text">
                <h3>What is a <b>spaced repetition</b> system ?</h3>
                <p>Studies have shown that you remember better after waiting increasingly longer between each review session.</p>
                <p>Using the <b>JapaLearn</b> application, when you learn a new <b>kanji</b> or <b>vocabulary</b> you will need to wait 4 hours before reviewing the item. If you succeed the review, you will then have to wait 8 hours before the next review. This is summarized in the following table.</p>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Item level</th>
                        <th>Time to wait before review</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>4 hours</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>8 hours</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>1 day</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>3 days</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>7 days</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>14 days</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>30 days</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>3 months</td>
                    </tr>
                    </tbody>
                </table>
                <p>After reaching level 8, the item will be considered "fully learned" and you will not have to review it again.</p>
            </div>
        </div>
    </div>

    <div class="section3 section">
        <div class="content">
            <div class="text">
                <h2>Learn by reading, speaking and listening</h2>
                <p>Here at <b>JapaLearn</b> we believe that to learn faster your have to immerse yourself in the <b>language</b>.</p>
                <p>We do not only teach the <b>kanjis</b> and vocabulary. Instead, we propose multiple study material.</p>

                <div>
                    <h3>Reading</h3>
                    <p>Choose from our collection of <b>Japanese short-story</b> and start learning ! We write each of our story by keeping in mind to keep them as simple as possible for learners.</p>
                    <p>We publish new stories every month !</p>
                </div>

                <div>
                    <h3>Speaking</h3>
                    <p>Speak directly with <b>Japanese teachers</b> by scheduling a lesson with them.</p>
                    <p>You will be able to work on your accent and get direct feedback from your teacher.</p>
                </div>

                <div>
                    <h3>Listening</h3>
                    <p>A lot of our content is accompanied with audio files. Instead of reading the stories why not listen to them ?</p>
                    <p>Practice your <b>pitch-accent</b> by hearing how a Japanese pronounce the vocabulary.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
