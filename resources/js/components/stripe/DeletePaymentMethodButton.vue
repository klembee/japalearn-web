<template>
    <md-button @click="deleteMethod" class="md-icon-button">
        <md-icon>delete</md-icon>
    </md-button>
</template>

<script>
    export default {
        name: "DeletePaymentMethodButton",
        props: {
            deleteEndpoint: {
                type: String,
                required: true
            },
            paymentId: {
                type: String,
                required: true
            }
        },
        methods:{
            deleteMethod: function(){
                let payload = {
                    payment_id: this.paymentId,
                };

                axios.post(this.deleteEndpoint, payload)
                    .then(function(response){
                        location.reload();
                    })
                    .catch(function(error){
                        console.log("Error while deleting payment method")
                        //todo (Jonathan): show error
                    })
            }
        }
    }
</script>

<style scoped>

</style>
