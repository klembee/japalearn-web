<template>
    <div>
        <h3>Leave a comment</h3>
        <md-field>
            <label>Your name</label>
            <md-input v-model="name"/>
        </md-field>

        <md-field>
            <label>Comment</label>
            <md-textarea v-model="comment"></md-textarea>
        </md-field>

        <md-button @click="submitComment" class="md-raised md-accent">Post comment</md-button>
    </div>

</template>

<script>
    export default {
        name: "LeaveComment",
        props: {
            leaveCommentEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                name: "",
                comment: ""
            }
        },
        methods: {
            submitComment(){
                let self = this;
                grecaptcha.ready(function(){
                    console.log('ready');

                    grecaptcha.execute('6LcmAwAVAAAAAAnM-_UF8eg6L_YMNCj67S_2FHKu', {action: 'submit'}).then(function(token){
                        console.log('executed');
                        let payload = {
                            name: self.name,
                            comment: self.comment,
                            recaptchaToken: token
                        };

                        axios.post(self.leaveCommentEndpoint, payload)
                            .then(function(response){
                                if(response.data.success){
                                    toastr.success("Comment posted successfully.")
                                }else{
                                    toastr.error("Failed to post comment.")
                                }
                            })
                            .catch(function(error){
                                toastr.error("Failed to post comment.")
                            })
                    })


                })


            }
        }
    }
</script>

<style scoped>

</style>
