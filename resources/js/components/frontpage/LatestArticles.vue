<template>
    <div>
        <ul class="list-unstyled">
            <li @click="readArticle(article)" v-for="article in articles" :key="article.id" class="article-item">
                <div class="article-img-container">
                    <img :src="article.small_image_url" class="article-img"/>
                </div>

                <div class="article-content">
                    <h4>{{article.title}}</h4>
                    <p>{{getAbstract(article)}}</p>
                </div>

            </li>
        </ul>
        <md-button :href="readMoreUrl" class="md-raised md-primary">Read more</md-button>
    </div>
</template>

<script>
    import Marked from "marked";

    export default {
        name: "LatestArticles",
        props: {
            apiEndpoint: {
                type: String,
                required: true
            },
            readUrl: {
                type: String,
                required: true
            },
            readMoreUrl: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                articles: []
            }
        },
        methods: {
            fetch(){
                let self = this;
                axios.get(this.apiEndpoint)
                    .then(function(response){
                        if(response.data.success){
                            self.articles = response.data.articles;
                        }else{
                            console.error("Failed to retrieve latest blog posts.")
                        }
                    })
                    .catch(function(error){
                        console.error("Failed to retrieve latest blog posts.")
                    })
            },
            getAbstract(article){
                let formatedContent = Marked(article.content);
                let soup = new JSSoup(formatedContent);
                return soup.getText(". ").substr(0, 100) + "...";
            },
            readArticle(article){
                window.location.href = this.readUrl.replace(":slug", article.slug);
            }
        },
        mounted() {
            this.fetch();
        }
    }
</script>

<style scoped>
    .article-item{
        padding: 15px 30px 15px 30px;
        border-bottom: 2px solid #f5f5f5;
        display:flex;
    }

    .article-content{
        flex-grow: 1;
        padding-left:20px;
    }

    .article-img-container{
        width:fit-content;
    }

    .article-img{
        min-width: 180px;
        max-width:180px;
        height: auto;
    }

    @media screen and (max-width: 600px){

        .article-img-container{
            margin: auto;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .article-item{
            flex-direction: column;
            padding: 0;
            padding-bottom:15px;
        }
    }

    li{
        cursor: pointer;
    }
</style>
