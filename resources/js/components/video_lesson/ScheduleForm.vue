<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <form>
                    <label for="date">Date (*You can only schedule lesson one week in advance)</label>
                    <md-field>
                        <md-input @input="dateChanged" v-model="date" :min="dateInOneWeek" type="date" id="date"/>
                    </md-field>
                    <span class="md-error" v-show="!dateIsValid">Date is not valid</span>

                    <md-field v-show="date && availableTimes">
                        <label>Time</label>
                        <md-select v-model="time">
                            <md-option v-for="(time, index) in availableTimes" :key="index" :value="time">{{time}}</md-option>
                        </md-select>
                    </md-field>

                    <md-field>
                        <label>How long do you want your lesson ?</label>
                        <md-select v-model="duration">
                            <md-option value="30">30 minutes</md-option>
                            <md-option value="60">60 minutes</md-option>
                            <md-option value="90">90 minutes</md-option>
                        </md-select>
                    </md-field>

                    <div>
                        <!-- Payment summary -->
                        <table class="table">
                            <tr>
                                <td>Subtotal</td>
                                <td>{{subtotal.toFixed(2)}} $</td>
                            </tr>
                            <tr>
                                <td>Taxes</td>
                                <td>{{taxes.toFixed(2)}} $</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>{{totalCost.toFixed(2)}} $</td>
                            </tr>
                        </table>

                        <credit-card-chooser
                            :user-email="userEmail"
                            :credit-cards="creditCards"
                            :amount="totalCost"
                            :save-method-endpoint="savePaymentMethodEndpoint"
                            :stripe-key="stripeKey"
                            :client-secret="clientSecret"
                            @card-selected="methodSelected"
                            @card-unselected="selectedCard = null"
                        ></credit-card-chooser>

                        <md-button :disabled="loading" v-show="isFormValid" @click="schedule()" class="md-accent md-raised">Schedule lesson and pay</md-button>
                    </div>

                </form>
            </div>
            <div class="col-md-3 offset-md-3">
                <div class="d-flex mb-2 align-items-center">
                    <md-avatar v-if="teacher.picture_path" class="md-large ml-0 mr-3">
                        <img :src="'/storage/' + teacher.picture_path"/>
                    </md-avatar>

                    <h2>{{teacher.name}}</h2>
                </div>
                <table class="table">
                    <tr>
                        <td>Cost per hour</td>
                        <td>{{(teacher.info.video_lesson_price_hour / 100).toFixed(2)}} $</td>
                    </tr>
                    <tr>
                        <td>Number of students</td>
                        <td>TODO</td>
                    </tr>
                    <tr>
                        <td>Rating</td>
                        <td>4.3 / 5.0</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
    import CreditCardChooser from "../CreditCardChooser";
    export default {
        name: "ScheduleForm",
        components: {CreditCardChooser},
        props: {
            scheduleEndpoint: {
                type: String,
                required: true
            },
            availableTimesEndpoint: {
                type: String,
                required: true
            },
            teacher: {
                type: Object,
                required: true
            },
            stripeKey: {
                type: String,
                required: true
            },
            clientSecret: {
                type: String,
                required: true
            },
            savePaymentMethodEndpoint: {
                type: String,
                required: true
            },
            creditCards: {
                type: Array,
            },
            userEmail: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                date: moment().add(1, "week").format("YYYY-MM-DD"),
                time: "",
                duration: 30,
                availableTimes: [],
                selectedCard: null,
                loading: false
            }
        },
        computed: {
            dateInOneWeek(){
                return moment().add(1, "week").format("YYYY-MM-DD")
            },
            dateIsValid(){
                return moment(this.date).isValid();
            },
            subtotal(){
                return (this.teacher.info.video_lesson_price_hour / 100) * (this.duration / 60.0)
            },
            taxes(){
                return 0.14975 * this.subtotal;
            },
            totalCost(){
                return this.subtotal + this.taxes;
            },
            isFormValid(){
                return this.time && this.selectedCard;
            }
        },
        methods: {
            formatedTime(time){
                return ""
            },
            getAvailableTimesForDate(){
                let payload = {
                    teacher_id: this.teacher.id,
                    date: this.date
                };

                let self = this;
                if(this.dateIsValid) {
                    axios.post(this.availableTimesEndpoint, payload)
                        .then(function (response) {
                            if (response.data.success) {
                                self.availableTimes = response.data.times;
                            } else {
                                toastr.error("Can't retrieve available times of this teacher.");
                            }
                        })
                        .catch(function (exception) {
                            toastr.error("Error while getting available times for specified date");
                        })
                }
            },
            schedule(){
                if(this.isFormValid) {
                    this.loading = true;

                    let payload = {
                        teacher_id: this.teacher.id,
                        date: this.date,
                        time: this.time,
                        duration: this.duration,
                        total: this.totalCost,
                        card: this.selectedCard,
                    };


                    let self = this;
                    axios.post(this.scheduleEndpoint, payload)
                        .then(function(response){
                            console.log(response);
                            if(response.data.success){
                                window.location.href = response.data.redirect_url;
                            }else{
                                toastr.error("Error while scheduling lesson. Try again later..")
                            }
                        })
                        .catch(function(error){
                            toastr.error("Error while scheduling lesson. Try again later.")
                            self.loading = false;
                        });
                }else{
                    toastr.error("You have to select a credit card.")
                    self.loading = false;
                }
            },
            dateChanged(){
                this.availableTimes = [];
                this.time = "";
                this.getAvailableTimesForDate();
            },
            methodSelected(method){
                this.selectedCard = method;
            }
        },
        mounted() {
            this.getAvailableTimesForDate()
        }
    }
</script>

<style scoped>

</style>
