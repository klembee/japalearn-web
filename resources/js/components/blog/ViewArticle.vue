<template>
    <div>
        <div class="frontImage">
            <img :src="'/storage/' + article.image_url"/>
        </div>
        <div class="row w-100 m-0">
            <div class="content col-11 col-sm-9 col-md-6">
                <h1>{{article.title}}</h1>
                <div class="article-text" v-html="parsedContent">

                </div>

                <hr />

                <div class="under-post">
                    <h3>Comments</h3>
                    <div v-for="comment in comments" :key="comment.id" class="comment-container">
                        <div class="comment-header">
                            <p><span class="comment_author_name">{{comment.author_name}}</span> <span>wrote:</span></p>
                            <p>{{comment.parsed_date}}</p>
                        </div>

                        <p>{{comment.comment}}</p>
                    </div>

                    <hr />

                    <leave-comment
                        :leave-comment-endpoint="leaveCommentEndpoint"
                    >

                    </leave-comment>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import Marked from "marked";
    import LeaveComment from "./LeaveComment";

    export default {
        name: "ViewArticle",
        components: {LeaveComment},
        props: {
            article: {
                type: Object,
                required: true
            },
            fetchCommentsEndpoint: {
                type: String,
                required: true
            },
            leaveCommentEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                parsedContent: "",
                comments: []
            }
        },
        methods: {
            fetchComments(page = 1){
                let self = this
                axios.get(this.fetchCommentsEndpoint + '?page=' + page)
                    .then(function(response){
                        console.log(response);
                        self.comments = self.comments.concat(response.data.data)
                    })
                    .catch(function(error){
                        console.log("Failed to fetch comments.")
                    })
            }
        },
        mounted() {
            this.parsedContent = Marked(this.article.content);
            this.fetchComments();
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

    .article-text{
        padding-left: 50px;
        padding-right: 50px;
        margin-top: 20px;
    }

    .comment_author_name{
        font-size:1.3em;
        font-weight: bold;
    }

    .comment-container{
        background-color: white;
        padding: 20px 20px 5px 20px;
        margin-bottom: 10px;
        box-shadow: -2px 2px 6px 1px #32525987;
    }

    .comment-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .under-post{
        width:60%;
        margin:auto;
    }

    /deep/ .content img {
        margin:auto;
        width:70%;
        display:block;
    }
</style>
