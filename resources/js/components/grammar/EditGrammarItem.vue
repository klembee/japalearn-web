<template>
    <div class="row">
        <div class="col-md-6 col-12">
            <div>
                <h2>Editing lesson</h2>
                <md-field>
                    <label for="title">Title</label>
                    <md-input id="title" v-model="item.title"/>
                </md-field>

                <label for="content">Content</label>
                <textarea id="content">

                </textarea>
            </div>

            <hr />

            <div>
                <h2>Add a question: </h2>
                <h3>Question</h3>
                <md-field>
                    <label for="question">Question</label>
                    <md-textarea id="question" v-model="newQuestion.question">

                    </md-textarea>
                </md-field>

                <!-- Answers -->
                <h3>Answers</h3>
                <div v-for="(answer, index) in newQuestion.answers" :key="index" class="row align-items-center">
                    <div class="col-10">
                        <md-field>
                            <label :for="'answer-' + index">Answer #{{index + 1}}</label>
                            <md-input :id="'answer-' + index" v-model="newQuestion.answers[index].answer"/>
                        </md-field>
                    </div>

                    <div class="col-2">
                        <md-button @click="removeCreationAnswer(index)" class="md-icon-button">
                            <md-icon>delete</md-icon>
                        </md-button>
                    </div>

                </div>

                <md-button class="md-primary md-raised" @click="newQuestion.answers.push({answer: ''})">New answer</md-button>

                <h3>Indication</h3>
                <md-field>
                    <label for="indication">Indication (If user get it wrong)</label>
                    <md-textarea id="indication" v-model="newQuestion.indication">

                    </md-textarea>
                </md-field>

                <md-button @click="saveQuestion" class="md-primary md-raised">Save question</md-button>

            </div>



        </div>
        <div class="col-md-6 col-12">
            <h2>Result</h2>
            <hr />
            <div id="result">
                <span v-html="parsedContent"></span>
            </div>
            <hr />
            <h2>Questions</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Question</th>
                    <th>Answers</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(question, index) in item.questions" :key="index">
                    <td>{{question.question}}</td>
                    <td>{{question.answers.map(answer => answer.answer).join(', ')}}</td>
                    <td>
                        <md-button @click="deleteQuestion(index)" class="md-icon-button">
                            <md-icon>delete</md-icon>
                        </md-button>
                    </td>
                </tr>
                </tbody>
            </table>

            <hr />

            <md-button @click="save" class="md-raised md-primary">Save</md-button>
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    </div>
</template>

<script>
    import marked from "marked";

    export default {
        name: "EditGrammarItem",
        props: {
            itemProp: {
                type: Object,
                required: true
            },
            saveEndpoint: {
                type: String,
                required: true
            },
            deleteQuestionEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                item: {
                    title: "",
                    content: "",
                    questions: []
                },
                newQuestion: {
                    question: "",
                    answers: [{
                        answer: ""
                    }],
                    indication: ""
                },
                markdownEditor: {},
                parsedContent: ""
            }
        },
        computed: {

        },
        methods: {
            save(){
                let payload = {
                    title: this.item.title,
                    content: this.markdownEditor.value(),
                    questions: this.item.questions
                };

                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            console.log("SAVED !");
                        }else{
                            console.log("Error while saving grammar item")
                            //todo (Jonathan): Show error to user
                        }
                    })
                    .catch(function(error){
                        console.log("Error while saving grammar item")
                        //todo (Jonathan): Show error to user
                    })
            },
            removeCreationAnswer(index){
                this.$delete(this.newQuestion.answers, index)
            },
            deleteQuestion(index){
                let payload = {
                    question_id: this.item.questions[index].id
                };

                axios.post(this.deleteQuestionEndpoint, payload)
                    .then(function(response){

                    })
                    .catch(function(error){

                    });

                this.$delete(this.item.questions, index)
            },
            saveQuestion(){
                this.item.questions.push(_.clone(this.newQuestion));

                this.newQuestion = {
                    question: "",
                    answers: [{
                        answer: ""
                    }],
                    indication: ""
                }
            }
        },
        mounted() {
            this.item = _.clone(this.itemProp);
            this.markdownEditor = new SimpleMDE();

            this.markdownEditor.value(this.item.content);
            this.parsedContent = marked(this.markdownEditor.value());


            let self = this;
            this.markdownEditor.codemirror.on("change", function(){
                self.parsedContent = marked(self.markdownEditor.value());
            });
        }
    }
</script>

<style scoped>

</style>
