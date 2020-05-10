<template>
    <div>
        <p>We are sorry to see you go</p>
        <p>By ending your subscription, you will loose access to the advantages.</p>

        <md-field>
            <label for="reason">Can we know the reason why you are leaving us ?</label>
            <md-select v-model="reason" name="reason" id="reason">
                <md-option value="too_many_bug">The app contains too many bugs</md-option>
                <md-option value="not_ennough_content">There is not enough content</md-option>
                <md-option value="poor_quality">The quality of the content is poor</md-option>
                <md-option value="too_exensive">It is too expensive</md-option>
                <md-option value="other">Other</md-option>
            </md-select>
        </md-field>

        <md-field v-if="reason === 'other'">
            <label for="specify">Please specify. Your opinion is invaluable to us.</label>
            <md-textarea id="specify" name="specify" v-model="specify">

            </md-textarea>
        </md-field>

        <md-button @click="cancel" type="button" class="md-raised">Keep subscription</md-button>
        <md-button @click="unsubscribe" type="submit" class="md-primary md-raised">Cancel subscription</md-button>
    </div>
</template>

<script>
    export default {
        name: "UnsubscriptionForm",
        props: {
            cancelUrl: {
                type: String,
                required: true
            },
            unsubscribeEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                reason: "",
                specify: ""
            }
        },
        methods: {
            cancel(){
                window.location.href = this.cancelUrl;
            },
            unsubscribe(){
                let self = this;
                let payload = {
                    reason: this.reason,
                    specify: this.specify
                };

                axios.post(this.unsubscribeEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            window.location.href = self.cancelUrl;
                        }else{
                            toastr.error("Error while unsubscribing. Please contact usa.")
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while unsubscribing. Please contact us.")
                    });
            }
        }
    }
</script>

<style scoped>

</style>
