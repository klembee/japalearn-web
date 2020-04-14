<template>
    <div>
        <review-panel
            :update-levels-endpoint="updateLevelsEndpoint"
            :remove-wrong="false"
            :items-to-review="reviews"
            :has-items-after-review="false"
        ></review-panel>
    </div>
</template>

<script>
    import ReviewPanel from "./ReviewPanel";
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
    }
</script>

<style scoped>

</style>
