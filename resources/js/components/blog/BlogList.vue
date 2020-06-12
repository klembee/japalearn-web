<template>
    <div class="row w-100 m-0">
        <div class="post col-12 col-md-8 col-lg-6">
            <md-card class="post-card" v-for="post in paginatedPosts.data" :key="post.id">
                <md-card-header>
                    <div class="image-container">
                        <img class="post_image" v-if="post.image_url" :src="post.image_url"/>
                    </div>

                    <div class="post-header">
                        <h2>{{post.title}}</h2>
                        <p>Published on {{parseDate(post.created_at)}}</p>
                    </div>

                </md-card-header>

                <md-card-content>
                    <p v-html="parse(post.content)"></p>
                </md-card-content>

                <md-card-actions>
                    <md-button v-if="editPostUrl" :href="editPostUrl.replace(':id', post.slug)" class="md-raised md-accent">Edit</md-button>
                    <md-button :href="viewPostUrl.replace(':id', post.slug)" class="md-raised md-accent">Read more</md-button>
                </md-card-actions>
            </md-card>
        </div>
    </div>

</template>

<script>
    import Marked from "marked";

    export default {
        name: "BlogList",
        props: {
            paginatedPosts: {
                type: Object,
                required: true
            },
            viewPostUrl: {
                type: String,
                required: true
            },
            editPostUrl: {
                type: String,
                required: false
            }
        },
        methods: {
            parse(text){
                let soup = new JSSoup(Marked(text));
                return soup.getText(". ").substr(0, 100) + "...";
            },
            parseDate(date){
                return moment(date).format("YYYY-MM-DD")
            }
        }
    }
</script>

<style scoped>
    .image-container{
        max-height:300px;
        overflow: hidden;
    }
    .post{
        margin:auto;
    }
    .post-card{
        margin-bottom:20px;
    }
    .post_image{
        float:none;
        border-radius:0;
        transform: translateY(-25%);
        display:block;
        margin:auto;
    }
    .post-header{
        margin-top:10px;
        border-bottom:1px solid #325259;
    }

    @media screen and (max-width:600px){
        .post_image{
            transform: none;
        }
    }
</style>
