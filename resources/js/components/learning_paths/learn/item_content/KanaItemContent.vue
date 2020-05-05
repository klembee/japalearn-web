<template>
    <div>
        <h2>Romaji: {{item.romaji}}</h2>
    </div>
</template>

<script>
    export default {
        name: "KanaItemContent",
        props: {
            item: {
                type: Object,
                required: true
            }
        },
    }
</script>

<style scoped>

</style>
