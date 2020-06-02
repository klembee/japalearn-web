<template>
    <div>
        <md-content v-if="currentItem">
            <h1 class="text-capitalize"><span :class="{meaning: currentItem.answer_type === 'meaning', reading: currentItem.answer_type === 'reading'}">{{currentItem.answer_type}}</span> of:</h1>
            <div class="item-word">
                <p>{{currentItem.question}}</p>
            </div>
            <div v-if="currentItem.answer_type === 'meaning'">
                <md-field :class="{error: hasError}">
                    <label>What is the meaning ?</label>
                    <md-input v-on:keyup.enter="submitAnswer" v-model="answer"/>
                    <md-button @click="submitAnswer" class="md-icon-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </md-field>
            </div>
            <div v-else-if="currentItem.answer_type === 'reading'">
                <md-field :class="{error: hasError}">
                    <label>What is the reading ?</label>
                    <md-input @input="transformToKana()" v-on:keyup.enter="submitAnswer" v-model="answer"/>
                    <md-button @click="submitAnswer" class="md-icon-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </md-field>
            </div>

            <!-- Answer -->
            <div v-if="showAnswer">
                <vocab-item-content
                    :item="currentItem"
                >

                </vocab-item-content>
            </div>

        </md-content>

        <back-drop v-show="readyForLearn" title="Congratulations !">
            <template v-slot:actions>
                <div v-if="hasItemsAfterReview">
                    <p>You did a great job ! Do you want to continue learning?</p>

                    <md-button @click="stopReview(true)" class="md-raised">Exit</md-button>
                    <md-button @click="stopReview()" class="md-raised">Continue with lessons</md-button>
                </div>
                <div v-else>
                    <p>You have no more items to learn.</p>

                    <md-button @click="stopReview(true)" class="md-raised">Exit</md-button>
                </div>
            </template>

        </back-drop>
    </div>
</template>

<script>
    import BackDrop from "../../BackDrop";
    import {toKana, isRomaji, isKana, toKatakana} from '../../../wanakana';
    import VocabItemContent from "./item_content/VocabItemContent";
    export default {
        name: "VocabReviewPanel",
        components: {VocabItemContent, BackDrop},
        props: {
            itemsToReview: {
                type: Array,
                required: false,
                default: function(){
                    return [];
                }
            },
            updateLevelsEndpoint: {
                type: String,
                required: true
            },
            removeWrong: {
                type: Boolean,
                default: false
            },
            hasItemsAfterReview: {
                type: Boolean,
                default: false
            }
        },
        data: function(){
            return {
                currentItemIndex: 0,
                answer: "",
                romajiAnswer: "",
                items: [],
                good: [],
                wrong: [],
                toSave: {
                    good: [],
                    wrong: []
                },
                readyForLearn: false,
                showAnswer: false,
                hasError: false
            }
        },
        computed: {
            itemTextProperty(){
                if(this.type === 'vocab'){
                    return 'word';
                }else if(this.type === 'kana'){
                    return 'kana';
                }
            },
            currentItem: function(){
                return this.items[this.currentItemIndex]
            },
        },
        methods: {
            submitAnswer(){
                if(this.currentItem.answer_type === 'reading') {
                    this.answer = toKana(this.answer);
                }

                if(this.showAnswer){
                    this.nextQuestion();
                    this.showAnswer = false;
                    return
                }

                if(!this.verifyAnswer()){
                    // There was an error with the input
                    this.hasError = true;

                }else{
                    this.hasError = false;

                    // After verifyAnswer, showAnswer could have changed
                    if(!this.showAnswer){
                        this.nextQuestion();
                    }
                }
            },
            verifyAnswer(){
                if(this.invalidAnswer()){
                    return false;
                }

                if(this.answerIsCorrect()){
                    //Good answer
                    if(this.removeWrong || this.wrong.filter(item => item.question === this.currentItem.question).length === 0) {

                        let alreadyGood = this.good.filter(item => item.question === this.currentItem.question).length > 0;
                        if(!alreadyGood) {
                            this.good.push(this.currentItem);

                            if(this.wrong.filter(item => item.question === this.currentItem.question).length === 0){
                                //If the item was wrong, dont save it as good
                                this.toSave.good.push(this.currentItem);
                            }

                        }
                    }
                    if(this.removeWrong){
                        // Remove the item that was wrong
                        this.wrong = this.wrong.filter(item => item != this.currentItem);
                    }
                    this.showAnswer = false
                }else{
                    //Wrong answer
                    //Add the item at the end of the list
                    this.items.push(this.currentItem);

                    if(!this.removeWrong) {
                        if (this.wrong.filter(item => item.question === this.currentItem.question).length === 0) {
                            this.wrong.push(this.currentItem);
                        }
                        this.toSave.wrong.push(this.currentItem)
                    }

                    // if(!this.removeWrong) {
                    //     this.good = this.good.filter(item => item != this.currentItem);
                    // }

                    this.showAnswer = true
                }

                this.saveResults();

                return true;
            },
            invalidAnswer(){
                let empty = this.answer === "" || this.answer == null;

                return empty;
            },
            nextQuestion(){
                this.answer = "";
                this.currentItemIndex += 1;

                if(this.currentItemIndex >= this.items.length){
                    this.saveResults();
                    this.readyForLearn = true;
                }
            },
            saveResults(){
                let data = {
                    good: this.toSave.good,
                    wrong: this.toSave.wrong
                };

                let self = this;
                axios.post(this.updateLevelsEndpoint, data)
                    .then(function(response){
                        console.log(response)
                        self.toSave.good = [];
                        self.toSave.wrong = [];
                    })
                    .catch(function(error){
                        toastr.error("Error while saving level");
                    })
            },
            stopReview(goHome = false){
                if(goHome){
                    this.$emit('go-home')
                }else{
                    this.$emit('review-end')
                }
            },
            transformToKana: _.debounce(function(){
                this.answer = toKana(this.answer)
            }, 330),
            answerIsCorrect(){
                let allAnswersToCheck = [
                    this.answer,
                    this.answer.replace(' ', ''),
                    this.answer.replace('-', ''),
                    this.answer.replace('-', '').replace(' ', '')
                ];

                if(isKana(this.answer)){
                    allAnswersToCheck.push(toKatakana(this.answer))
                }

                let rightAnswers = [];

                this.currentItem.answers.forEach(rightAnswer => {
                    rightAnswers.push(rightAnswer);
                    rightAnswers.push(rightAnswer.replace(' ', ''));
                    rightAnswers.push(rightAnswer.replace('-', ''));
                    rightAnswers.push(rightAnswer.replace(' ', '').replace('-', ''));
                });

                var goodAnswer = false;

                allAnswersToCheck.forEach(answer => {
                    rightAnswers.forEach(rightAnswer => {
                        if(answer.toLowerCase() === rightAnswer.toLowerCase()){
                            goodAnswer =  true;
                        }
                    });
                });

                return goodAnswer;
            }
        },
        mounted() {
            this.itemsToReview.forEach(item => {
                if(item.type === "radical"){
                    this.items.push({
                        question: item.word,
                        answers: item.answers,
                        answer_type: 'meaning',
                        type: item.type,
                        meanings: item.meanings,
                        meaning_mnemonic: item.meaning_mnemonic,
                        reading_mnemonic: item.reading_mnemonic,
                        readings: item.readings,
                        word_type_id: item.word_type_id,
                        id: item.id,
                    })
                }else{
                    this.items.push({
                        question: item.word,
                        answers: item.answers.meanings,
                        answer_type: 'meaning',
                        type: item.type,
                        meanings: item.meanings,
                        meaning_mnemonic: item.meaning_mnemonic,
                        reading_mnemonic: item.reading_mnemonic,
                        on_readings: item.on_readings,
                        kun_readings: item.kun_readings,
                        word_type_id: item.word_type_id,
                        id: item.id,
                    });

                    this.items.push({
                        question: item.word,
                        answers: item.answers.readings,
                        answer_type: 'reading',
                        type: item.type,
                        meanings: item.meanings,
                        meaning_mnemonic: item.meaning_mnemonic,
                        reading_mnemonic: item.reading_mnemonic,
                        on_readings: item.on_readings,
                        kun_readings: item.kun_readings,
                        word_type_id: item.word_type_id,
                        id: item.id,
                    });
                }
            });

            this.items = _.shuffle(this.items);

        }
    }
</script>

<style scoped>
    .meaning{
        background-color: #d9363626;
        padding: 5px 10px 5px 10px;
    }
    .reading{
        background-color: #32525926;
        padding: 5px 10px 5px 10px;
    }
</style>
