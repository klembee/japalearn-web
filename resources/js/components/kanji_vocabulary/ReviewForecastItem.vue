<template>
    <div class="card" v-if="showHours">
        <div class="card-header" :id="id + '-day'">
            <h2>{{weekDay}}</h2>
        </div>
        <div class="collapse show" :aria-labelledby="id + '-day'" data-parent="#accordion">
            <ul class="mt-3">
                <li v-for="(hour) in sortedHours" class="entry" v-if="hourNotYetPassed(hour)"><b>{{hour}}:</b> +{{hours[hour]}} reviews</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReviewForecastItem",
        props: {
            day: {
                type: Object,
                required: true
            },
            weekDay: {
                type: String,
                required: true
            },
            hours: {},
            id: {
                type: String,
                required: true
            }
        },
        computed: {
            sortedHours: function(){
                return Object.keys(this.hours).sort()
            },
            showHours: function(){

                var allHoursAfterNow = true;
                let self = this;

                if(this.hours) {
                    Object.keys(this.hours).forEach(hour => {
                        if(!self.hourNotYetPassed(hour)){
                            allHoursAfterNow = false
                        }
                    });
                }else{
                    allHoursAfterNow = false
                }

                return allHoursAfterNow
            }
        },
        methods: {
            hourNotYetPassed(hour){

                let hours = hour.split(":")[0];
                let minutes = hour.split(":")[1];

                let reviewDate = this.day.clone().startOf('day').add(hours, 'hours').add(minutes, "minutes");
                let now = moment();

                return reviewDate.isAfter(now);
            }
        }
    }
</script>

<style scoped>
    .entry{
        font-size:1.5em;
    }
</style>
