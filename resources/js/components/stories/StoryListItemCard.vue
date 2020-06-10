<template>
    <div class="row m-0">
        <md-card class="story-card col-11 col-sm-10 col-md-8 col-lg-5" :class="{locked: !this.canAccessStory}">
            <md-card-header>
                <div class="story-image mb-2" v-if="story.front_image_url">
                    <img :src="'/storage/' + story.front_image_url"/>
                </div>
                <h2 class="m-0">{{story.title}}</h2>
            </md-card-header>
            <md-card-content>
                <div class="abstract" v-html="parsedAbstract">

                </div>
            </md-card-content>
            <md-card-actions>
                <md-button v-if="canAccessStory" :href="realReadUrl" class="md-primary md-raised">Read more</md-button>
                <div v-else class="locked_reason">
                    <p class="m-0 h4">This item is locked because you are not subscribed.</p>
                    <p class="m-0">Unlock all the stories by subscribing.</p>
                    <md-button :href="subscribeUrl" class="md-raised md-accent mb-2 mt-2">Click here to subscribe</md-button>
                </div>

            </md-card-actions>
        </md-card>
    </div>

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
            },
            userSubscribed: {
                type: Boolean,
                default: false
            },
            subscribeUrl: {
                type: String,
                required: true
            }
        },
        computed: {
            canAccessStory(){
                return (this.story.subscriber_only === 0) || (this.userSubscribed);
            },
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
        overflow-y: hidden;
    }

    .story-image img{
        width: 100%;
        border-radius: 15px;
        margin-bottom: 15px;
    }

    .abstract {
        padding-left: 10px;
        padding-right: 10px;
        font-family: notosans, "Nunito", sans-serif;
        letter-spacing: 2px;
    }

    .locked_reason{
        width: 100%;
        z-index: 7;
        background-color: #f3f3f3;
        padding-left: 10px;
        padding-top: 10px;
        font-size: 1.3em;
        border-radius: 5px;
    }

    .locked:before{
        position: absolute;
        content: '';
        background: rgba(0, 0, 0, 0.65);
        width: 100%;
        height: 100%;
        /*pointer-events: none;*/
        z-index: 6;
        margin-left: -15px;
    }

    /deep/ .abstract p{
        display: inline !important;
    }
</style>
