<template>
    <div>
        <component
            :is="reviewComponent"
            :update-levels-endpoint="updateLevelsEndpoint"
            :remove-wrong="false"
            :items-to-review="reviews"
            :has-items-after-review="false"
            @go-home="goHome()"
        >

        </component>
    </div>
</template>

<script>
    import VocabReviewPanel from "./learn/VocabReviewPanel";
    import KanaReviewPanel from "./learn/KanaReviewPanel";

    export default {
        name: "VocabReviewWindow",
        components: {KanaReviewPanel, VocabReviewPanel},
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
            },
            type: {
                type: String,
                default: "vocab"
            }
        },
        computed: {
            reviewComponent(){
                if(this.type === "vocab"){
                    return "VocabReviewPanel";
                }else if(this.type === "kana"){
                    return "KanaReviewPanel";
                }
            },
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
