<template>
    <div class="row">
        <div class="col-md-6 col-12">
            <div>
                <h2>Editing lesson</h2>
                <md-field>
                    <label for="title">Title</label>
                    <md-input id="title" v-model="item.title"/>
                </md-field>

                <div class="mb-3">
                    <input type="checkbox" v-model="item.subscriber_only" />
                    Subscriber only
                </div>



                <label for="content">Content</label>
                <textarea id="content">

                </textarea>

<!--                <md-field>-->
<!--                    <label>Slug</label>-->
<!--                    <md-input v-model="item.slug"/>-->
<!--                </md-field>-->
            </div>

            <md-field>
                <label>Meta description</label>
                <md-textarea v-model="item.meta_description">

                </md-textarea>
            </md-field>

            <h3>Image:</h3>
            <image-selector
                :aspect-ratio="16/9"
                @image-changed="imageChanged">

            </image-selector>
            <md-field>
                <label>Image alt</label>
                <md-input v-model="item.front_image_alt"/>
            </md-field>
            <hr />

            <h3>Vocabulary</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Word</th>
                        <th>Reading</th>
                        <th>Meaning</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="vocab in item.vocab" :key="vocab.id">
                        <td>{{vocab.word}}</td>
                        <td>{{vocab.reading}}</td>
                        <td>{{vocab.meaning}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <input v-model="newVocab.word"/>
                        </td>
                        <td>
                            <input v-model="newVocab.reading"/>
                        </td>
                        <td>
                            <input v-model="newVocab.meaning"/>
                        </td>
                        <td>
                            <md-button @click="addVocab">Add</md-button>
                        </td>
                    </tr>
                </tbody>
            </table>

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
                    slug: "",
                    questions: [],
                    meta_description: "",
                    image_data: "",
                    front_image_alt: "",
                    subscriber_only: true
                },
                newQuestion: {
                    question: "",
                    answers: [{
                        answer: ""
                    }],
                    indication: ""
                },
                newVocab: {
                    word: "",
                    reading: "",
                    meaning: ""
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
                    questions: this.item.questions,
                    vocab: this.item.vocab,
                    meta_description: this.item.meta_description,
                    image_data: this.item.image_data,
                    front_image_alt: this.item.front_image_alt,
                };

                if(this.item.subscriber_only ){
                    payload['subscriber_only'] = this.item.subscriber_only;
                }

                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            console.log("SAVED !");
                        }else{
                            toastr.error("Error while saving grammar item");
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while saving grammar item");
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
                        toastr.error("Error while deleting question");
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
            },
            addVocab(){
                this.item.vocab.push(_.clone(this.newVocab));
                this.newVocab = {
                    word: "",
                    reading: "",
                    meaning: ""
                }
            },
            imageChanged(dataurl){
                this.item.image_data = dataurl;
            },
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
