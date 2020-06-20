<template>
    <div class="review-content">
        <div>
            <div class="question" v-html="formatedQuestion"></div>
            <md-field :class="{error: showInvalid, animate__headShake: showInvalid || showWrongAnswer}" class="animate__animated">
                <label for="answer">Answer</label>
                <md-input @input="changeToHiraganaIfNeeded"  v-on:keyup.enter="submitAnswer" id="answer" v-model="answer"/>
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
    import {toKana, isRomaji, isKana} from '../../wanakana';

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
            },
            updateGrammarLevelEndpoint: {
                type: String,
                required: true
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
                return this.currentQuestion + 1 <= 5 && this.currentQuestion + 1 < this.questions.length;
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

                    if (this.isGoodAnswer) {
                        if (this.hasNextQuestion) {
                            this.nextQuestion();
                        } else {
                            this.updateLevel();
                            this.lessonFinished = true;
                        }

                    } else {
                        this.gotWrongAnswer = true;
                        this.showErrorSnackbar = true;
                        this.showWrongAnswer = true;
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
            },
            changeToHiraganaIfNeeded(){
                if(isKana(this.question.answers[0])){
                    //Transform answer to kana
                    // this.answer = toKana(this.answer);
                    if(this.answer[this.answer.length - 1] !== 'n') {
                        if(this.answer[this.answer.length - 1] !== 'y') {
                            this.answer = toKana(this.answer)
                        }
                    }else{
                        if(this.answer[this.answer.length - 2] === 'n'){
                            // Last two characters are n. Remove the last one and switch to ん
                            this.answer = this.answer.slice(0, this.answer.length - 1);
                            this.answer = toKana(this.answer)
                        }
                    }
                }
            },
            updateLevel(){
                let payload = {
                    grammar_id: this.questions[0].grammar_item_id
                };

                axios.post(this.updateGrammarLevelEndpoint, payload)
                    .then(function(response){
                        if(!response.data.success){
                            console.log("Failed to update level of grammar item")
                        }
                    })
                    .catch(function(error){
                        console.log("Failed to update level of grammar item")
                    })
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
