<template>
    <md-card>
        <md-card-header>
            <h3>Choose a card</h3>
        </md-card-header>
        <md-card-content>
            <md-tabs>
                <md-tab id="tab-saved" md-label="Saved cards">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Card</th>
                            <th>Expiry</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="selectedCard">
                            <td colspan="2">Selected Card</td>
                            <td>
                                <md-button @click="paymentMethodUnselected" class="md-primary md-raised">Unselect</md-button>
                            </td>

                        </tr>
                        <tr v-else v-for="card in creditCards" :key="card.id">
                            <td>**** **** **** {{card.last4}}</td>
                            <td>{{card.exp_month}}/{{card.exp_year}}</td>
                            <td>
                                <md-button @click="paymentMethodSelected(card.id)" class="md-primary md-raised">Select</md-button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </md-tab>
                <md-tab id="new-card" md-label="New card">
                    <h3>New payment method</h3>
                    <new-payment-method-form
                        :user-email="userEmail"
                        :save-method-endpoint="saveMethodEndpoint"
                        :stripe-key="stripeKey"
                        :client-secret="clientSecret"
                        :reload-on-success="false"
                        @payment-method-added="paymentMethodSelected"
                    >

                    </new-payment-method-form>
                </md-tab>
            </md-tabs>
        </md-card-content>
    </md-card>
</template>

<script>
    export default {
        name: "CreditCardChooser",
        props:{
            userEmail: {
                type: String,
                required: true
            },
            creditCards: {
                type: Array
            },
            amount: {
                type: Number,
                required: true
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
                selectedCard: null
            }
        },
        methods: {
            paymentMethodSelected(paymentMethod){
                this.selectedCard = paymentMethod;
                this.$emit('card-selected', paymentMethod);
            },
            paymentMethodUnselected(){
                this.selectedCard = null;
                this.$emit('card-unselected');
            }
        }
    }
</script>

<style scoped>

</style>
