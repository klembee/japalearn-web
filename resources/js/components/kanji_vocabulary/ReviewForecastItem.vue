<template>
    <div class="card">
        <div class="card-header" :id="id + '-day'">
            <h2>{{weekDay}}</h2>
        </div>
        <div v-if="hours" class="collapse show" :aria-labelledby="id + '-day'" data-parent="#accordion">
            <ul class="mt-3">
                <li v-for="(nbReviews, hour) in hours" class="entry"><b>{{hour}}:</b> +{{nbReviews}} reviews</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReviewForecastItem",
        props: {
            weekDay: {
                type: String,
                required: true
            },
            hours: {},
            id: {
                type: String,
                required: true
            }
        }
    }
</script>

<style scoped>
    .entry{
        font-size:1.5em;
    }
</style>
