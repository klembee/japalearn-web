<template>
    <div>
        <div v-if="!isDoingReview">
            <learning-panel
                :items="items"
                @do-review="startReview"
            ></learning-panel>
        </div>

        <!-- When the user is doing a review -->
        <div v-else>
            <review-panel
                :update-levels-endpoint="updateLevelsEndpoint"
                :remove-wrong="true"
                :items-to-review="reviews[chunkToReview]"
                :has-items-after-review="chunkToReview + 1 >= items.length"
                @review-end="stopReview"
                @go-home="goHome"
            ></review-panel>
        </div>
    </div>


</template>

<script>
    import LearningPanel from "./LearningPanel";
    import ReviewPanel from "./ReviewPanel";
    export default {
        name: "VocabLessonWindow",
        components: {ReviewPanel, LearningPanel},
        props: {
            updateLevelsEndpoint: {
                type: String,
                required: true
            },
            dashboardUrl: {
                type: String,
                required: true
            },
            items: {
                type: Array,
                required: false,
                default: function(){
                    return []
                }
            },
            reviews: {
                type: Array,
                required: true
            }
        },
        data: function(){
            return {
                isDoingReview: false,
                chunkToReview: 0
            }
        },
        methods: {
            startReview(chunkIndex){
                this.isDoingReview = true;
                this.chunkToReview = chunkIndex
            },
            stopReview(){
                this.isDoingReview = false
                this.items = this.items.slice(1)
            },
            goHome(){
                window.location.href = this.dashboardUrl;
            }
        }
    }
</script>

<style scoped>
    /deep/ .item-word > p{
        text-align: center;
        font-size: 8em;
    }

    /deep/ p{
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
    }
</style>
