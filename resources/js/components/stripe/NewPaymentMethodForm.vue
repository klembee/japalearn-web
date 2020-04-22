<template>
    <div>
        <div id="card-element"></div>

        <div>
            <md-field>
                <label>Card holder's name</label>
                <md-input v-model="cardHolderName"></md-input>
            </md-field>
        </div>

        <md-button class="md-raised md-primary" @click="addMethod" id="card-button">
            Update Payment Method
        </md-button>
    </div>
</template>

<script>
    export default {
        name: "NewPaymentMethodForm",
        props: {
            stripeKey: {
                type: String,
                required: true
            },
            clientSecret: {
                type: String,
                required: true
            },
            saveMethodEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
              return {
                  stripe: {},
                  elements: {},
                  cardElement: {},
                  cardHolderName: ""
              }
        },
        methods: {
            mountStripeElements(){
                this.cardElement.mount("#card-element");
            },
            addMethod(){
                let self = this;

                this.stripe.confirmCardSetup(
                    this.clientSecret, {
                        payment_method: {
                            card: this.cardElement,
                            billing_details: {
                                name: this.cardHolderName
                            }
                        }
                    }
                ).then(function(response){
                    if(response.setupIntent){
                        let payload = {
                            payment: response.setupIntent.payment_method
                        };

                        axios.post(self.saveMethodEndpoint, payload)
                            .then(function(response){
                                if(response.data.success){
                                    location.reload();
                                }else{
                                    console.log(response.data.message);
                                }
                            })
                            .catch(function(error){
                                console.log("Error while saving payment method.");
                                //todo (Jonathan): Show error to client
                            })
                    }else{
                        //todo: Print error
                    }


                }).catch(function(error){
                    console.log(error);
                    //todo (Jonathan): Show error to client
                });
            }
        },
        mounted() {
            this.stripe = Stripe(this.stripeKey);
            this.elements = this.stripe.elements();
            this.cardElement = this.elements.create('card');

            this.mountStripeElements();
        }
    }
</script>

<style scoped>

</style>
