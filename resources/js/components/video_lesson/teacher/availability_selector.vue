<template>
    <div>
        <h2>Your availability</h2>
        <div class="table-container">
            <table class="table">
                <thead>
                <tr>
                    <td></td>
                    <td>Monday</td>
                    <td>Tuesday</td>
                    <td>Wednesday</td>
                    <td>Thursday</td>
                    <td>Friday</td>
                    <td>Saturday</td>
                    <td>Sunday</td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="hour in hours" :key="hour">
                    <td class="headcol">{{hour}}</td>
                    <td class="clickable" @click="toggleAvailability(availability.monday, unsavedAvailability.monday, hour)" :class="tableItemClass(availability.monday, unsavedAvailability.monday, hour)"></td>
                    <td class="clickable" @click="toggleAvailability(availability.tuesday, unsavedAvailability.tuesday, hour)" :class="tableItemClass(availability.tuesday, unsavedAvailability.tuesday, hour)"></td>
                    <td class="clickable" @click="toggleAvailability(availability.wednesday, unsavedAvailability.wednesday, hour)" :class="tableItemClass(availability.wednesday, unsavedAvailability.wednesday, hour)"></td>
                    <td class="clickable" @click="toggleAvailability(availability.thursday, unsavedAvailability.thursday, hour)" :class="tableItemClass(availability.thursday, unsavedAvailability.thursday, hour)"></td>
                    <td class="clickable" @click="toggleAvailability(availability.friday, unsavedAvailability.friday, hour)" :class="tableItemClass(availability.friday, unsavedAvailability.friday, hour)"></td>
                    <td class="clickable" @click="toggleAvailability(availability.saturday, unsavedAvailability.saturday, hour)" :class="tableItemClass(availability.saturday, unsavedAvailability.saturday, hour)"></td>
                    <td class="clickable" @click="toggleAvailability(availability.sunday, unsavedAvailability.sunday, hour)" :class="tableItemClass(availability.sunday, unsavedAvailability.sunday, hour)"></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    export default {
        name: "availability_selector",
        props: {
            saveAvailabilityEndpoint: {
                type: String,
                required: true
            },
            fetchAvailabilityEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                availability:{
                    monday: [],
                    tuesday: [],
                    wednesday: [],
                    thursday: [],
                    friday: [],
                    saturday: [],
                    sunday: [],
                },
                unsavedAvailability:{
                    monday: [],
                    tuesday: [],
                    wednesday: [],
                    thursday: [],
                    friday: [],
                    saturday: [],
                    sunday: [],
                },
                hours: [
                    "06:00",
                    "06:30",
                    "07:00",
                    "07:30",
                    "08:00",
                    "08:30",
                    "09:00",
                    "09:30",
                    "10:00",
                    "10:30",
                    "11:00",
                    "11:30",
                    "12:00",
                    "12:30",
                    "13:00",
                    "13:30",
                    "14:00",
                    "14:30",
                    "15:00",
                    "15:30",
                    "16:00",
                    "16:30",
                    "17:00",
                    "17:30",
                    "18:00",
                    "18:30",
                    "19:00",
                    "19:30",
                    "20:00",
                    "20:30",
                    "21:00",
                    "21:30",
                    "22:00",
                    "22:30",
                ]
            }
        },
        computed:{
            hasUnsavedAvailability(){
                let monday = this.unsavedAvailability.monday.length > 0;
                let tuesday = this.unsavedAvailability.tuesday.length > 0;
                let wednesday = this.unsavedAvailability.wednesday.length > 0;
                let thursday = this.unsavedAvailability.thursday.length > 0;
                let friday = this.unsavedAvailability.friday.length > 0;
                let saturday = this.unsavedAvailability.saturday.length > 0;
                let sunday = this.unsavedAvailability.sunday.length > 0;

                return monday || tuesday || wednesday || thursday || friday || saturday || sunday;
            },
        },
        methods: {
            tableItemClass(availability, unsavedAvailability, hour){
                return {
                    available: availability.includes(hour),
                    saved: !unsavedAvailability.includes(hour)
                }
            },
            toggleAvailability(availability_array, availability_unsavedArray, hour){
                if(availability_array.includes(hour)){
                    const removeIndex = availability_array.indexOf(hour);
                    availability_array.splice(removeIndex, 1);
                }else{
                    availability_array.push(hour);
                }

                availability_unsavedArray.push(hour);
                this.saveAvailability();
            },
            saveAvailability: _.debounce(function(){
                if(this.hasUnsavedAvailability){
                    // Because user can add items while api is saving
                    let availability_to_save = _.clone(this.unsavedAvailability);

                    let payload = {
                        availabilities: availability_to_save
                    };

                    let self = this;
                    axios.post(this.saveAvailabilityEndpoint, payload)
                        .then(function(response){

                            // Remove the items that were saved
                            self.unsavedAvailability.monday = self.unsavedAvailability.monday.filter(a => availability_to_save.monday.indexOf(a) < 0);
                            self.unsavedAvailability.tuesday = self.unsavedAvailability.tuesday.filter(a => availability_to_save.tuesday.indexOf(a) < 0);
                            self.unsavedAvailability.wednesday = self.unsavedAvailability.wednesday.filter(a => availability_to_save.wednesday.indexOf(a) < 0);
                            self.unsavedAvailability.thursday = self.unsavedAvailability.thursday.filter(a => availability_to_save.thursday.indexOf(a) < 0);
                            self.unsavedAvailability.friday = self.unsavedAvailability.friday.filter(a => availability_to_save.friday.indexOf(a) < 0);
                            self.unsavedAvailability.saturday = self.unsavedAvailability.saturday.filter(a => availability_to_save.saturday.indexOf(a) < 0);
                            self.unsavedAvailability.sunday = self.unsavedAvailability.sunday.filter(a => availability_to_save.sunday.indexOf(a) < 0);

                            self.$forceUpdate();

                            toastr.success("Availability updated");

                        })
                        .catch(function(error){
                            toastr.error("Error while saving availability");
                        })
                }
            }, 700),
            fetchAvailabilities(){
                let self = this;
                axios.get(this.fetchAvailabilityEndpoint)
                    .then(function(response){
                        console.log(response);
                        // Parse the availabilities
                        let data = response.data;

                        if(data.count > 0){
                            let availabilityData = data.data;
                            if(availabilityData.monday){
                                self.availability.monday = self.availability.monday.concat(availabilityData.monday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                            if(availabilityData.tuesday){
                                self.availability.tuesday = self.availability.tuesday.concat(availabilityData.tuesday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                            if(availabilityData.wednesday){
                                self.availability.wednesday = self.availability.wednesday.concat(availabilityData.wednesday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                            if(availabilityData.thursday){
                                self.availability.thursday = self.availability.thursday.concat(availabilityData.thursday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                            if(availabilityData.friday){
                                self.availability.friday = self.availability.friday.concat(availabilityData.friday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                            if(availabilityData.saturday){
                                self.availability.saturday = self.availability.saturday.concat(availabilityData.saturday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                            if(availabilityData.sunday){
                                self.availability.sunday = self.availability.sunday.concat(availabilityData.sunday.map(time => moment(time.hour, "HH:mm:ss").format("HH:mm")))
                            }
                        }

                    })
                    .catch(function(error){
                        toastr.error("Error while retrieving availabilities");
                    })
            }
        },
        mounted() {
            this.fetchAvailabilities();
        }
    }
</script>

<style scoped>
    td.available{
        background-color:#a2e4a2;
    }

    td.available.saved{
        background-color: #75a675;
    }

    td{
        padding:20px;
    }

    .headcol{
        position: absolute;
        left: 0;
        top: auto;
        border-top-width: 1px;
        /*only relevant for first row*/
        padding:0;
        background-color:white;
        height:100%;
        /*border-right: 1px solid black*/
    }

    .table-container{
        width:100%;
        overflow-x: auto;
    }

</style>
