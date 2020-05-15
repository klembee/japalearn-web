<template>
    <div>
        <div v-if="!isDoingReview">
            <learning-panel
                :items="items"
                @do-review="startReview"
                :type="type"
                :current-chunk="chunkToReview"
            ></learning-panel>
        </div>

        <!-- When the user is doing a review -->
        <div v-else class="review-content">
            <component
                :is="reviewComponent"
                :update-levels-endpoint="updateLevelsEndpoint"
                :remove-wrong="true"
                :items-to-review="nextReviewItems"
                :has-items-after-review="chunkToReview + 1 < items.length"
                @review-end="stopReview"
                @go-home="goHome"
            ></component>
        </div>
    </div>


</template>

<script>
    import LearningPanel from "./learn/LearningPanel";
    import VocabReviewPanel from "./learn/VocabReviewPanel";
    import KanaReviewPanel from "./learn/KanaReviewPanel";

    export default {
        name: "VocabLessonWindow",
        components: {KanaReviewPanel, VocabReviewPanel, LearningPanel},
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
            type: {
                type: String
            }
        },
        data: function(){
            return {
                isDoingReview: false,
                chunkToReview: 0,
            }
        },
        computed:{
            reviewComponent(){
                if(this.type === "vocab"){
                    return "VocabReviewPanel";
                }else if(this.type === "kana"){
                    return "KanaReviewPanel";
                }

            },
            nextReviewItems(){
                return this.items[this.chunkToReview]
            }
        },
        methods: {
            startReview(chunkIndex){
                console.log(this.items.length);
                console.log(this.chunkToReview);
                this.isDoingReview = true;
                this.chunkToReview = chunkIndex
            },
            stopReview(){
                this.isDoingReview = false;
                //todo: Dont mutate the prop
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
