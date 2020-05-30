<template>
    <div>
        <div v-for="i in maxStars" class="star">
            <span v-if="i > rating">☆</span>
            <span v-else>★</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StarRating",
        props: {
            maxStars: {
                type: Number,
                default: 5
            },
            rating: {
                type: Number,
                required: true
            }
        }
    }
</script>

<style scoped>
    .star{
        display:inline-block;
        font-size:2.3em;
    }
</style>
