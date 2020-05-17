<template>
    <div class="review-content">
        <div>
            <div class="question" v-html="formatedQuestion"></div>
            <md-field :class="{error: showInvalid, animate__headShake: showInvalid || showWrongAnswer}" class="animate__animated">
                <label for="answer">Answer</label>
                <md-input  v-on:keyup.enter="submitAnswer" id="answer" v-model="answer"/>
                <md-button @click="submitAnswer" class="md-icon-button">
                    <md-icon>send</md-icon>
                </md-button>
            </md-field>
            <md-button v-show="gotWrongAnswer" @click="showAnswers = !showAnswers" class="md-accent md-raised">Show answer</md-button>
            <div v-show="showAnswers" class="answers">
                <h2>Answer: </h2>
                <ul>
                    <li v-for="answer in question.answers" :key="answer">
                        {{answer}}
                    </li>
                </ul>
                <hr />
                <div v-if="question.indication">
                    <h2>Indication: </h2>
                    <p v-html="formatedIndication" class="indication-text">

                    </p>
                </div>

            </div>
        </div>


        <back-drop v-show="lessonFinished" title="Congratulations !">
            <template v-slot:actions>
                <div>
                    <p>You did a great job !</p>

                    <md-button v-if="lastLessonUrl" @click="goToLastLesson" class="md-accent md-raised">Go back to last grammar lesson</md-button>
                    <md-button v-if="nextLessonUrl" @click="goToNextLesson" class="md-accent md-raised">Go to next grammar lesson</md-button>
                </div>
            </template>
        </back-drop>

        <md-snackbar :md-duration="2000" :md-active.sync="showErrorSnackbar">
            <p>Wrong answer try again or check the answer !</p>
        </md-snackbar>
    </div>
</template>

<script>
    import BackDrop from "../BackDrop";
    import Marked from "marked"
    export default {
        name: "GrammarReviews",
        components: {BackDrop},
        props: {
            questions: {
                type: Array,
                required: true
            },
            nextLessonUrl: {
                type: String,
            },
            lastLessonUrl: {
                type: String
            }
        },
        data: function(){
            return {
                answer: "",
                currentQuestion: 0,
                lessonFinished: false,
                showErrorSnackbar: false,
                showInvalid: false,
                showWrongAnswer: false,
                gotWrongAnswer: false,
                showAnswers: false
            }
        },
        computed: {
            question(){
                return this.questions[this.currentQuestion];
            },
            formatedQuestion(){
                return Marked(this.question.question);
            },
            formatedIndication(){
                if(this.question.indication){
                    return Marked(this.question.indication);
                }
                return "";
            },
            hasNextQuestion(){
                return this.currentQuestion + 1 <= 5;
            },
            isGoodAnswer(){
                return this.question.answers.includes(this.answer)
            },
            isValid(){
                return this.answer.length > 0;
            }
        },
        methods: {
            submitAnswer(){
                // Reset the animation
                this.showWrongAnswer = false;

                if(this.isValid) {
                    this.showInvalid = false;
                    if (this.hasNextQuestion) {
                        if (this.isGoodAnswer) {
                            this.nextQuestion();
                        } else {
                            this.gotWrongAnswer = true;
                            this.showErrorSnackbar = true;
                            this.showWrongAnswer = true;
                        }
                    } else {
                        this.lessonFinished = true;
                    }
                }else{
                    this.showInvalid = true
                }
            },
            nextQuestion(){
                this.answer = "";
                this.showInvalid = false;
                this.showWrongAnswer = false;
                this.gotWrongAnswer = false;
                this.showAnswers = false;
                this.currentQuestion++;
            },
            goToLastLesson(){
                if(this.lastLessonUrl) {
                    window.location.href = this.lastLessonUrl;
                }
            },
            goToNextLesson(){
                if(this.nextLessonUrl){
                    window.location.href = this.nextLessonUrl;
                }
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>
    .question{
        font-size:2.0em;
        text-align:center;
    }
    /deep/ .question img {
        max-height:500px;
    }

    .answers {
        padding: 15px;
        background-color: #f7f7f7;
        border: 1px solid #325259;
        border-radius: 10px;
        margin-top:15px;
    }

    .indication-text{
        margin-left: 20px;
        margin-top: 10px;
    }
</style>
