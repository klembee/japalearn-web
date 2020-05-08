<template>
    <div class="chat-window">
        <div class="chat-flex" v-if="conversation">
            <div @click="minimized = !minimized" class="conversation-header">
                <md-avatar>
                    <img src="https://randomuser.me/api/portraits/men/22.jpg"/>
                </md-avatar>
                <h3 class="conversation-name d-inline-block mb-0">{{conversation.with_user.name}}</h3>
                <md-button @click="closeConversation()" class="md-icon-button exit-conv-button">
                    <md-icon>clear</md-icon>
                </md-button>
            </div>
            <div v-show="!minimized">
                <div class="conversation" id="the_conversation">
                    <md-list>
                        <md-list-item v-for="message in conversation.messages" :key="message.id">
                            <div class="single-message" :class="{'reverse': message.from_id !== conversation.with_user.id}">
                                <md-avatar class="message-avatar mr-2 ml-0">
                                    <img src="https://randomuser.me/api/portraits/men/22.jpg"/>
                                </md-avatar>
                                <div class="text">
                                    <p>{{message.message}}</p>
                                </div>
                            </div>
                        </md-list-item>
                    </md-list>
                </div>
                <div class="response-form d-flex">
                    <md-field>
                        <label>Your message</label>
                        <md-input @keyup.enter.native="sendMessage" v-model="messageToSend"></md-input>
                    </md-field>
                    <md-button @click="sendMessage" class="md-icon-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name: "ChatWindow",
        props: {
            conversation: {
                type: Object
            },
            sendMessageEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                messageToSend: "",
                minimized: false
            }
        },
        methods: {
            sendMessage: function(){
                let data = {
                    to_user_id: this.conversation.with_user.id,
                    message: this.messageToSend
                };

                let self = this;

                let message_id = 0;
                if(self.conversation.messages.length > 0){
                    message_id = self.conversation.messages[self.conversation.messages.length - 1].id + 1
                }

                self.newMessage({
                    from_id: -1,
                    message: self.messageToSend,
                    read: 1,
                    to_id: self.conversation.with_user.id,
                    id: message_id,
                });

                axios.post(this.sendMessageEndpoint, data)
                    .then(function(response){
                        self.messageToSend = "";
                    })
                    .catch(function(error){
                        toastr.error("Error while sending message !");
                    });
            },
            closeConversation: function(){
                this.$emit('close');
            },
            goToBottomOfConversation: function(){
                var element = document.getElementById("the_conversation");
                element.scrollTop = element.scrollHeight
            },
            newMessage(message){
                this.conversation.messages.push(message);
                this.conversation.last_message = message;
                this.goToBottomOfConversation()
            }
        },
        watch: {
            'conversation.with_user.id': {
                handler: function(newConv){
                    // Scroll to the bottom of the conversation
                    this.goToBottomOfConversation()
                },
                deep: true
            }
        },
        created() {

        },
        mounted(){
            this.goToBottomOfConversation()


        }
    }
</script>

<style scoped>
    .chat-window{
        width: 20rem;
        background-color: #f1f1f1;
        display:inline-block;
    }
    .chat-flex{
        display: flex;
        flex-flow: column;
        height: 100%;
    }
    .conversation-header{
        padding: 20px 20px 10px 20px;
        border-bottom: 1px solid #dadada;
        flex: 0 1 auto;
        cursor: pointer;
    }
    .conversation-name{
        vertical-align: middle;
        margin-left: 10px;
        max-width: 10rem;
    }
    .conversation{
        flex:1 1 auto;
        border-bottom: 1px solid #dadada;
        overflow-y: scroll;
        max-height:17rem;
    }
    .response-form{
        padding-left: 10px;
        padding-right: 10px;
        align-items:center;
        flex: 0 1 auto;
    }
    .single-message{
        display:flex;
        width:100%;
    }
    .reverse{
        flex-direction:row-reverse;
    }
    .reverse > .message-avatar{
        margin-left: 8px !important;
    }
    .single-message > .text{
        padding: 10px;
        background-color: #efefef;
        border-radius: 10px;
        max-width: 13rem;
        white-space: initial;
    }
    .single-message > .text > p{
        margin-bottom:5px;
    }
    .exit-conv-button{
        float:right;
    }
</style>
