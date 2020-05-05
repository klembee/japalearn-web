<template>
    <div>
        <review-panel
            :update-levels-endpoint="updateLevelsEndpoint"
            :remove-wrong="false"
            :items-to-review="reviews"
            :has-items-after-review="false"
            @go-home="goHome()"
        ></review-panel>
    </div>
</template>

<script>
    import ReviewPanel from "./learn/VocabReviewPanel";
    export default {
        name: "VocabReviewWindow",
        components: {ReviewPanel},
        props: {
            updateLevelsEndpoint: {
                type: String,
                required: true
            },
            dashboardUrl: {
                type: String,
                required: true
            },
            reviews: {
                type: Array,
                required: true
            }
        },
        methods:{
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
