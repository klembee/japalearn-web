<template>
    <div class="row m-0 mt-3">
        <div class="col-xl-8 col-12">
            <h2>Please select a plan</h2>
            <div class="all-plan-container">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-2">
                        <div class="plan-container">
                            <div class="content">
                                <div class="plan-header">
                                    <h3>Month</h3>
                                    <div>
                                        <p class="pricing">${{month.amount / 100}} CAD</p>
                                    </div>
                                </div>

                                <hr />
                                <p>Access to all the kanjis and vocabulary, all stories available and test your skills when learning the grammar.</p>
                                <hr />
                                <p class="small">Recurring charge every month <sup>1</sup></p>
                            </div>
                            <button @click="selectMonth" class="select-plan">Select</button>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="plan-container">
                            <div class="content">
                                <div class="plan-header">
                                    <h3>Three months</h3>
                                    <div>
                                        <p class="pricing">${{trimonth.amount / 100}} CAD</p>
                                    </div>
                                </div>
                                <hr />
                                <p>Access to all the kanjis and vocabulary, all stories available and test your skills when learning the grammar.</p>
                                <hr />
                                <p class="small">Recurring charge every three months <sup>1</sup></p>
                            </div>


                            <button @click="selectTriMonth" class="select-plan">Select</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="plan-container">
                            <div class="content">
                                <div class="plan-header">
                                    <h3>Annual</h3>
                                    <div>
                                        <p class="pricing">${{year.amount / 100}} CAD</p>
                                    </div>
                                </div>
                                <hr />
                                <p>Access to all the kanjis and vocabulary, all stories available and test your skills when learning the grammar.</p>
                                <hr />
                                <p class="small">Recurring charge every year <sup>1</sup></p>
                            </div>

                            <button @click="selectYear" class="select-plan">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <ol>
                <li>
                    <p>JapaLearn will charge you at the beginning of a subscription period. A period begins on the date when a subscription is added and ends a month, three month or one year after the date depending on the selected plan.</p>
                    <p>You can cancel your subscription any time.</p>
                </li>
            </ol>
        </div>

        <div class="col-xl-4 col-12">
            <div v-if="selectedPlan">
                <h2>Payment</h2>

                <credit-card-chooser
                    :user-email="userEmail"
                    :credit-cards="creditCards"
                    :amount="selectedPlan.amount"
                    :save-method-endpoint="saveMethodEndpoint"
                    :stripe-key="stripeKey"
                    :client-secret="clientSecret"
                    @card-selected="methodSelected"
                    @card-unselected="selectedCard = null"
                    class="mb-3"
                >

                </credit-card-chooser>

                <div v-if="selectedCard">
                    <p>You will be charged ${{selectedPlan.amount / 100}} CAD when you proceed with the payment.</p>
                    <md-button @click="pay" :disabled="isSubscribing"  class="md-raised md-primary">Proceed to payment</md-button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import CreditCardChooser from "../../CreditCardChooser";
    export default {
        name: "SubscriptionPage",
        components: {CreditCardChooser},
        props: {
            userEmail: {
                type: String,
                required: true
            },
            subscribeEndpoint: {
                type: String,
                required: true
            },
            redirectUrl: {
                type: String,
                required: true
            },
            month: {
                type: Object,
                required: true
            },
            trimonth: {
                type: Object,
                required: true
            },
            year: {
                type: Object,
                required: true
            },
            creditCards: {
                type: Array,
            },
            saveMethodEndpoint: {
                type: String,
                required: true
            },
            stripeKey: {
                type: String,
                required: true
            },
            clientSecret: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                selectedPlan: null,
                selectedCard: null,
                isSubscribing: false
            }
        },
        methods: {
            methodSelected(method){
                this.selectedCard = method;
            },
            pay(){
                this.isSubscribing = true;

                let payload = {
                    card_id: this.selectedCard,
                    plan_id: this.selectedPlan.id
                };

                let self = this;
                axios.post(this.subscribeEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            ga('send', 'event', 'subscription', 'subscribed', 'subscribed', self.selectedPlan.amount / 100, {
                                hitCallback: function(){
                                    window.location.href = response.data.redirect;
                                }
                            });

                        }else{
                            toastr.error("Error while subscribing: " + response.data.message);
                            self.isSubscribing = false;
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while subscribing");
                        self.isSubscribing = false;
                    })
            },
            selectMonth(){
                this.selectedPlan = this.month;
                ga('send', 'event', 'subscription', 'selected', 'selected', 2);
            },
            selectTriMonth(){
                this.selectedPlan = this.trimonth;
                ga('send', 'event', 'subscription', 'selected', 'selected', 6);
            },
            selectYear(){
                this.selectedPlan = this.year;
                ga('send', 'event', 'subscription', 'selected', 'selected', 10);
            }
        }
    }
</script>

<style scoped>
    .all-plan-container{
        margin-bottom: 30px;
    }

    .plan-container{
        padding:0;
        border-radius: 15px;
        border: 2px solid #e2e2e2;
        background-color: #f9f9f9;;
        height:fit-content;
    }

    .plan-header{
        text-align:center;
    }

    .pricing{
        font-weight:bold;
    }

    .content {
        padding:15px;
    }

    .select-plan:focus{
        outline: none;
    }

    .select-plan{
        background-color: #325259;
        color: white;
        border: none;
        width: 100%;
        border-bottom-left-radius: 13px;
        border-bottom-right-radius: 13px;
        height:40px;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    }
</style>
