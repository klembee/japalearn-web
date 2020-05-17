<template>
    <div>
        <div id="card-element"></div>

        <div>
            <md-field>
                <label>Card holder's name</label>
                <md-input v-model="cardHolderName"></md-input>
            </md-field>

            <md-field>
                <label>Street address</label>
                <md-input v-model="streetAddress"></md-input>
            </md-field>

            <md-field>
                <label>City</label>
                <md-input v-model="city"></md-input>
            </md-field>

            <md-field>
                <label>Province</label>
                <md-input v-model="province"></md-input>
            </md-field>

            <md-field>
                <label>Country</label>
                <md-select v-model="country">
                    <md-option value="CA">Canada</md-option>
                </md-select>
            </md-field>
        </div>

        <md-button class="md-raised md-accent" @click="addMethod" id="card-button">
            Add Payment Method
        </md-button>
    </div>
</template>

<script>
    export default {
        name: "NewPaymentMethodForm",
        props: {
            userEmail: {
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
            },
            saveMethodEndpoint: {
                type: String,
                required: true
            },
            reloadOnSuccess: {
                type: Boolean,
                default: true
            }
        },
        data: function(){
              return {
                  stripe: {},
                  elements: {},
                  cardElement: {},
                  cardHolderName: "",
                  streetAddress: "",
                  city: "",
                  zipcode: "",
                  province: "",
                  country: "CA",
                  style:{
                      base: {
                          color: '#32325d',
                          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                          fontSmoothing: 'antialiased',
                          fontSize: '16px',
                          '::placeholder': {
                              color: '#aab7c4'
                          }
                      },
                      invalid: {
                          color: '#fa755a',
                          iconColor: '#fa755a'
                      }
                  }
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
                                name: this.cardHolderName,
                                email: this.userEmail,
                                address: {
                                    city: this.city,
                                    country: this.country,
                                    line1: this.streetAddress,
                                    // postal_code: this.zipcode,
                                    state: this.province,
                                },
                            }
                        }
                    }
                ).then(function(response){
                    if(response.setupIntent){
                        let payload = {
                            payment: response.setupIntent.payment_method,

                        };

                        axios.post(self.saveMethodEndpoint, payload)
                            .then(function(response){
                                if(response.data.success){
                                    let paymentMethod = response.data.payment_method;
                                    if(self.reloadOnSuccess) {
                                        location.reload();
                                    }else{
                                        // Send payment information to parent
                                        self.$emit('payment-method-added', paymentMethod);
                                    }
                                }else{
                                    toastr.error("Error while saving payment method");
                                }
                            })
                            .catch(function(error){
                                console.log(error);
                                toastr.error("Error while saving payment method.");
                            })
                    }else{
                        toastr.error("You need to fill your address information !");
                    }


                }).catch(function(error){
                    toastr.error("Failed to add payment method.");
                });
            }
        },
        mounted() {
            this.stripe = Stripe(this.stripeKey);
            this.elements = this.stripe.elements();
            this.cardElement = this.elements.create('card', {style: this.style});

            this.mountStripeElements();
        }
    }
</script>

<style scoped>

</style>
