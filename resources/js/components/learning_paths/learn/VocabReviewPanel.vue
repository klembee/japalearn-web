<template>
    <div>
        <md-content v-if="currentItem">
            <div class="item-word">
                <p>{{currentItem.question}}</p>
            </div>
            <div v-if="currentItem.answer_type === 'meaning'">
                <md-field>
                    <label>What is the meaning ?</label>
                    <md-input v-on:keyup.enter="submitAnswer" v-model="answer"/>
                    <md-button @click="submitAnswer" class="md-icon-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </md-field>
            </div>
            <div v-else-if="currentItem.answer_type === 'reading'">
                <md-field>
                    <label>What is the reading ?</label>
                    <md-input v-on:keyup.enter="submitAnswer" v-model="answer"/>
                    <md-button @click="submitAnswer" class="md-icon-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </md-field>
            </div>

        </md-content>

        <back-drop v-show="readyForLearn" title="Congratulations !">
            <template v-slot:actions>
                <div v-if="hasItemsAfterReview">
                    asdfasdf
                    <md-button @click="stopReview(true)" class="md-raised">Exit</md-button>
                    <md-button @click="stopReview()" class="md-raised">Continue with lessons</md-button>
                </div>
                <div v-else>
                    You have no more items to learn.

                    <md-button @click="stopReview(true)" class="md-raised">Exit</md-button>
                </div>
            </template>

        </back-drop>
    </div>
</template>

<script>
    import BackDrop from "../../BackDrop";
    export default {
        name: "VocabReviewPanel",
        components: {BackDrop},
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
                this.verifyAnswer();
                this.nextQuestion();
            },
            verifyAnswer(){
                if(this.currentItem.answers.includes(this.answer.toLowerCase())){
                    //Good answer
                    if(this.removeWrong || !this.wrong.includes(this.currentItem)) {
                        this.good.push(this.currentItem);
                    }
                    if(this.removeWrong){
                        // Remove the item that was wrong
                        this.wrong = this.wrong.filter(item => item != this.currentItem);
                    }
                }else{
                    //Wrong answer
                    console.log("WRONG!");
                    //Add the item at the end of the list
                    this.items.push(this.currentItem);

                    if(!this.wrong.includes(this.currentItem)) {
                        this.wrong.push(this.currentItem);
                    }

                }
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
                if(item.type === "radical"){
                    this.items.push({
                        question: item.word,
                        answers: item.answers,
                        answer_type: 'meaning',
                        type: item.type
                    })
                }else{
                    this.items.push({
                        question: item.word,
                        answers: item.answers.meanings,
                        answer_type: 'meaning',
                        type: item.type
                    });

                    this.items.push({
                        question: item.word,
                        answers: item.answers.readings,
                        answer_type: 'reading',
                        type: item.type
                    });
                }
            });

            this.items = _.shuffle(this.items);

        }
    }
</script>

<style scoped>

</style>
