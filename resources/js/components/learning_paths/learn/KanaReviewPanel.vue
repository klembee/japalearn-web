<template>
    <div>
        <md-content v-if="currentItem">
            <div class="item-word">
                <p>{{currentItem.question}}</p>
            </div>
            <div>
                <md-field :class="{error: hasError}">
                    <label>What is the romaji ?</label>
                    <md-input v-on:keyup.enter="submitAnswer" v-model="answer"/>
                    <md-button @click="submitAnswer" class="md-icon-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </md-field>
            </div>

            <!-- Answer -->
            <div v-if="showAnswer">
                <kana-item-content
                    :item="currentItem"
                >

                </kana-item-content>
            </div>

        </md-content>

        <back-drop v-show="readyForLearn" title="Congratulations !">
            <template v-slot:actions>
                <div v-if="hasItemsAfterReview">
                    <p>Do you wish to continue with the lessons ?</p>

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
    import KanaItemContent from "./item_content/KanaItemContent";
    export default {
        name: "VocabReviewPanel",
        components: {KanaItemContent, BackDrop},
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
                items: [],
                good: [],
                wrong: [],
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
                    console.log("invalid");
                    return false;
                }


                if(this.currentItem.answers.includes(this.answer.toLowerCase())){
                    //Good answer
                    if(this.removeWrong || !this.wrong.includes(this.currentItem)) {
                        this.good.push(this.currentItem);
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

                    if(!this.wrong.includes(this.currentItem)) {
                        this.wrong.push(this.currentItem);
                    }

                    this.showAnswer = true
                }

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
                    good: this.good,
                    wrong: this.wrong
                };

                let self = this;
                axios.post(this.updateLevelsEndpoint, data)
                    .then(function(response){
                        console.log(response)
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
        },
        mounted() {
            this.itemsToReview.forEach(item => {
                this.items.push({
                    id: item.id,
                    question: item.kana,
                    answers: item.romaji,
                    kana: item.kana,
                    romaji: item.romaji,
                    mnemonic: item.mnemonic,
                    sound_file: item.sound_file
                })
            });

            this.items = _.shuffle(this.items);

        }
    }
</script>

<style scoped>

</style>
