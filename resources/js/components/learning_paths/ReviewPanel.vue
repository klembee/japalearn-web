<template>
    <div>
        <md-content v-if="currentItem">
            <div class="item-word">
                <p>{{currentItem.question}}</p>
            </div>
            <div v-if="currentItem.type === 'meaning'">
                <md-field>
                    <label>What is the meaning ?</label>
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
    import BackDrop from "../BackDrop";
    export default {
        name: "ReviewPanel",
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
                    console.log("CORRECT");
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
                        console.log("Error while saving level")
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
            this.items = _.clone(this.itemsToReview)
        }
    }
</script>

<style scoped>

</style>
