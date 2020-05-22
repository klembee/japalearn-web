<template>
    <div class="accordion" id="accordion">
        <div v-if="Object.keys(times).length > 0">
            <review-forecast-item
                :day="getMomentDay(0)"
                :week-day="getWeekDay(0)"
                :hours="days[0]"
                id="zero"
            >
            </review-forecast-item>

            <review-forecast-item
                :day="getMomentDay(1)"
                :week-day="getWeekDay(1)"
                :hours="days[1]"
                id="one"
            >
            </review-forecast-item>

            <review-forecast-item
                :day="getMomentDay(2)"
                :week-day="getWeekDay(2)"
                :hours="days[2]"
                id="two"
            >
            </review-forecast-item>

            <review-forecast-item
                :day="getMomentDay(3)"
                :week-day="getWeekDay(3)"
                :hours="days[3]"
                id="three"
            >
            </review-forecast-item>

            <review-forecast-item
                :day="getMomentDay(4)"
                :week-day="getWeekDay(4)"
                :hours="days[4]"
                id="four"
            >
            </review-forecast-item>

            <review-forecast-item
                :day="getMomentDay(5)"
                :week-day="getWeekDay(5)"
                :hours="days[5]"
                id="five"
            >
            </review-forecast-item>

            <review-forecast-item
                :day="getMomentDay(6)"
                :week-day="getWeekDay(6)"
                :hours="days[6]"
                id="six"
            >
            </review-forecast-item>
        </div>
        <p v-else>No reviews planned.</p>

    </div>
</template>

<script>
    import ReviewForecastItem from "./ReviewForecastItem";
    export default {
        name: "ReviewForecast",
        components: {ReviewForecastItem},
        props: {
            numberReviewsPerDay: {
                type: Object,
                required: true
            }
        },
        data: function(){
            return {
                times: {},
                days: []
            }
        },
        methods: {
            getMomentDay(n){
                let today = moment();
                let nDays = today.add(n, 'days');
                return nDays;
            },
            getDay(n){
                let today = moment();
                let nDays = today.add(n, 'days').format("YYYY-MM-DD");

                return this.times[nDays]
            },
            getWeekDay(n){
                if(n === 0){
                    return "Today";
                }

                let today = moment();
                let nDays = today.add(n, 'days').format("dddd");

                return nDays;

            }
        },
        beforeMount() {
            Object.keys(this.numberReviewsPerDay).forEach(date => {
                let a = moment(date, "YYYY-MM-DD HH:mm:ss");
                let datePart = a.format("YYYY-MM-DD");
                let timePart = a.format("HH:mm");

                if(!this.times[datePart]){
                    this.times[datePart] = {}
                }

                this.times[datePart][timePart] = this.numberReviewsPerDay[date];
            });

            this.days.push(this.getDay(0));
            this.days.push(this.getDay(1));
            this.days.push(this.getDay(2));
            this.days.push(this.getDay(3));
            this.days.push(this.getDay(4));
            this.days.push(this.getDay(5));
            this.days.push(this.getDay(6));
        }
    }
</script>

<style scoped>

</style>
