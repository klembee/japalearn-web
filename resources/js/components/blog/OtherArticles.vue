<template>
    <div class="clickable other-articles-container">

        <h3>Other articles</h3>
        <div class="row m-0">
            <a class="col-12 col-md-4" :href="article.url" v-for="article in articles" :key="article.id">
                <div class="other-article">
                    <img :src="article.small_image_url"/>
                    <h4>{{article.title}}</h4>
                    <p>{{article.abstract}}</p>
                </div>
            </a>
        </div>

    </div>

</template>

<script>
    export default {
        name: "OtherArticles",
        props: {
            articles: {
                type: Array,
                required: true
            }
        }
    }
</script>

<style scoped>
    .other-article h4{
        margin-top:10px;
    }

    .other-article img{
        max-width: 228px;
        min-width: 228px;
    }

    .other-articles-container a{
        color:inherit;
        display:block;
    }

    .other-articles-container a:hover{
        color:inherit;
        text-decoration: none;
    }

</style>
