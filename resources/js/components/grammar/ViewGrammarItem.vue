<template>
    <div>
        <div class="content">

            <md-button @click="goBack" class="md-raised md-accent back-button">Back to lesson list</md-button>
            <md-card class="grammar-card">
                <md-card-content>
                    <h1 class="title">{{item.title}}</h1>

                    <div v-html="parsedContent">

                    </div>

                    <hr />

                    <div v-if="practiceUrl">
                        <div v-if="item.questions && item.questions.length > 0">
                            <md-button :href="practiceUrl" class="md-primary md-raised">Practice</md-button>
                        </div>
                    </div>
                    <div v-else>
                        <p>Login to practice this grammar lesson !</p>
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
            }
        },
        mounted() {
            this.parsedContent = Marked(this.item.content);
        }
    }
</script>

<style scoped>
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

    /deep/ table{
        width:fit-content;
        margin:auto;
        font-size:1.3em;

        max-width: 100%;
        overflow-x: scroll;
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
