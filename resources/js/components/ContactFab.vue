<template>
    <div class="email-fab">
        <div v-if="display" class="send-email-form">
            <h2>Send us an email</h2>
            <form method="post" :action="postUrl">
                <md-field>
                    <label for="email">Email</label>
                    <md-input id="email" name="email" required/>
                </md-field>
                <md-field>
                    <label for="name">Name</label>
                    <md-input id="name" name="name" required/>
                </md-field>

                <md-field>
                    <label for="message">Message</label>
                    <md-textarea id="message" name="message" required>

                    </md-textarea>
                </md-field>
                <md-button type="submit" class="md-primary md-raised">Send</md-button>
            </form>
        </div>
        <div>
            <md-button class="md-icon-button email-open-btn" @click="display = !display">
                <md-icon class="md-large">
                    message
                </md-icon>
            </md-button>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ContactFab",
        props: {
            postUrl: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                display: false
            }
        }
    }
</script>

<style scoped>
    .email-fab{
        position: fixed;
        right: 1rem;
        bottom: 1rem;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    .email-open-btn{
        margin-top: 10px;
        background-color: white;
        border: 3px solid #a2a2a2;
        width: 60px;
        height: 60px;
    }

    .email-open-btn:focus{
        outline:none !important;
    }

    .send-email-form{
        background-color: white;
        padding: 20px;
        border: 2px solid #8a8a8a;
    }
</style>
