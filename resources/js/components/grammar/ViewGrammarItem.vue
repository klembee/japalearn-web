<template>
    <div>
        <div class="content">

            <md-button @click="goBack" class="md-raised md-accent back-button">Back to lesson list</md-button>
            <md-card class="grammar-card">
                <md-card-content>
                    <h1 class="title">{{item.title}}</h1>

                    <div v-html="parsedContent" class="grammar-content">

                    </div>

                    <hr />

                    <div class="row m-0">
                        <div class="col-md-8 col-12">
                            <!-- Vocab -->
                            <div>
                                <h3>Vocabulary used in the examples</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Word</th>
                                        <th>Reading</th>
                                        <th>Meaning</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="vocab in item.vocab" :key="vocab.id">
                                        <td>{{vocab.word}}</td>
                                        <td>{{vocab.reading}}</td>
                                        <td>{{vocab.meaning}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <h3>Practice this lesson</h3>
                            <div v-if="practiceUrl">
                                <div v-if="item.questions && item.questions.length > 0">
                                    <md-button :href="practiceUrl" class="md-primary md-raised">Practice</md-button>
                                </div>
                                <div v-else>
                                    <p>This grammar chapter does not have questions</p>
                                    <md-button @click="markAsDone" class="md-raised md-accent">Mark as done</md-button>
                                </div>
                            </div>
                            <div v-else>
                                <p>Login to practice this grammar lesson !</p>
                            </div>
                        </div>
                    </div>

                </md-card-content>
            </md-card>

        </div>
    </div>

</template>

<script>
    import Marked from "marked";

    export default {
        name: "ViewGrammarItem",
        props: {
            item: {
                type: Object,
                required: true
            },
            markAsDoneUrl: {
                type: String
            },
            backUrl: {
                type: String,
                required: true
            },
            practiceUrl: {
                type: String,
                default: null
            }
        },
        data: function(){
            return {
                parsedContent: ""
            }
        },
        methods: {
            goBack(){
                window.location.href = this.backUrl;
            },
            markAsDone(){
                if(this.markAsDoneUrl){
                    let payload = {
                        grammar_id: this.item.id
                    };

                    let self = this;
                    axios.post(this.markAsDoneUrl, payload)
                        .then(function(response){
                            if(response.data.success){
                                self.goBack();
                            }else{
                                Toastr.error("Error while marking as done")
                            }
                        })
                        .catch(function(error){
                            Toastr.error("Error while marking as done")
                        })
                }
            }
        },
        mounted() {
            this.parsedContent = Marked(this.item.content);
        }
    }
</script>

<style scoped>
    .grammar-content{
        font-size: 1.3em;
    }

    .back-button{
        margin-left:16px;
        margin-bottom:10px;
    }
    .title{
        text-align: center;
    }
    .content{
        margin:auto;
    }

    /deep/ blockquote {
        font-size: 1.2em;
    }

    /deep/ .grammar-content table{
        width:fit-content;
        margin:auto;
        font-size:1.3em;

        max-width: 100%;
        overflow-x: auto;
        display: block;
    }

    /deep/ table th{
        border-bottom:2px solid #325259;
        color:#325259;
    }
    /deep/ table td{
        padding:8px;
    }
</style>
