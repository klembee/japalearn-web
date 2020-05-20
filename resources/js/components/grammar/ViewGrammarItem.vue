<template>
    <div class="row w-100 m-0">
        <div class="content col-lg-7 col-md-9 col-12">

            <md-button @click="goBack" class="md-raised md-accent back-button">Back to lesson list</md-button>
            <md-card>
                <md-card-content>
                    <h1 class="title">{{item.title}}</h1>

                    <div v-html="parsedContent">

                    </div>

                    <hr />

                    <p>Login to practice this grammar lesson !</p>
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
            }
        },
        data: function(){
            return {
                parsedContent: ""
            }
        },
        methods: {
            goBack(){
                window.history.back();
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
</style>
