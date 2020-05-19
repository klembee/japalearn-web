<template>
    <div>
        <div class="frontImage">
            <img :src="'/storage/' + article.image_url"/>
        </div>
        <div class="row w-100">
            <div class="content col-12 col-sm-8 col-md-6">
                <h1>{{article.title}}</h1>
                <div v-html="parsedContent">

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Marked from "marked";

    export default {
        name: "ViewArticle",
        props: {
            article: {
                type: Object,
                required: true
            }
        },
        data: function(){
            return {
                parsedContent: ""
            }
        },
        mounted() {
            this.parsedContent = Marked(this.article.content);
        }
    }
</script>

<style scoped>
    .frontImage{
        width:100%;
        max-height:650px;
        overflow:hidden;
    }

    .frontImage img{
        width:100%;
        filter: blur(4px) brightness(0.7);
    }

    .content{
        margin:auto;
        background-color:#f5f5f5;
        position:relative;
        bottom:100px;
        border-radius:5px;
        border: 2px solid #325259;
    }

    .content h1{
        text-align: center;
    }
</style>
