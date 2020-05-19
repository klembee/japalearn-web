<template>
    <md-card class="story-card">
        <md-card-header>
            <div class="story-image mb-2" v-if="story.front_image_url">
                <img :src="'/storage/' + story.front_image_url"/>
            </div>
            <h2>{{story.title}}</h2>
        </md-card-header>
        <md-card-content>
            <div class="abstract" v-html="parsedAbstract">

            </div>
        </md-card-content>
        <md-card-actions>
            <md-button :href="realReadUrl" class="md-primary md-raised">Read more</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
    import marked from "marked";

    export default {
        name: "StoryListItemCard",
        props: {
            story: {
                type: Object,
                required: true
            },
            readUrl: {
                type: String,
                required: true
            }
        },
        computed: {
            realReadUrl: function(){
                return this.readUrl.replace(':story_id', this.story.slug);
            },
            parsedAbstract: function(){
                return marked(this.story.content.substr(0, 100));
            }
        }
    }
</script>

<style scoped>
    .story-card{
        margin: auto auto 15px;
    }

    .story-image{
        height: 300px;
        overflow-y: hidden;
    }

    .story-image img{
        width:100%;
        transform: translateY(-20%);
    }

    .abstract {
        padding-left: 10px;
        padding-right: 10px;
        font-family: notosans, "Nunito", sans-serif;
        letter-spacing: 2px;
    }

    /deep/ .abstract p{
        display: inline !important;
    }
</style>
