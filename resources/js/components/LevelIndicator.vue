<template>
    <div>
        <div class="indicator">
            <span v-for="n in nbLevels" :class="{done: level >= n}">

            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LevelIndicator",
        props: {
            level: {
                type: Number,
                required: true
            },
            nbLevels: {
                type: Number,
                required: true
            }
        }
    }
</script>

<style scoped>
    .indicator{
        width:fit-content;
        margin:auto;
    }

    .indicator span.done{
        background-color: #99D0F2;
    }

    .indicator span {
        background-color: #F2F2F2;
        width: 10px;
        height: 7px;
        display: inline-block;
        border: 1px solid #325259;
    }

    .indicator span:first-child{
        border-bottom-left-radius: 10px;
        border-top-left-radius: 10px;
    }

    .indicator span:last-child{
        border-bottom-right-radius: 10px;
        border-top-right-radius: 10px;
    }
</style>
