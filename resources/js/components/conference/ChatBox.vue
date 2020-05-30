<template>
    <div>
        <div class="messages">
            <ul class="message-list" id="message-list">
                <li v-for="message in messages" :key="message.id">
                    <div class="message_item" :class="{'flex-row-reverse': message.from.id === ownId}">
                        <md-avatar class="m-0">
                            <img v-if="message.from.picture_path" :src="'/storage/' + message.from.picture_path"/>
                            <img v-else src="/images/no_profile_image.png" />
                        </md-avatar>
                        <p>{{message.message}}</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="field">
            <md-field class="m-0 chat-field">
                <label>Message</label>
                <md-input v-on:keyup.enter="sendMesssage" v-model="messageToSend"/>
                <md-button @click="sendMesssage" class="md-icon-button">
                    <md-icon>send</md-icon>
                </md-button>

            </md-field>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChatBox",
        props: {
            messagesProp: {
                type: Array
            },
            ownId: {
                type: Number
            },
            otherId: {
                type: Number,
                required: true
            },
            sendMessageEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                messages: [],
                messageToSend: "",
                sendingMessage: false,
                newMessageSound: new Audio("/sound/message-notification.wav")
            }
        },
        methods: {
            sendMesssage(){
                if(!this.sendingMessage) {
                    this.sendingMessage = true;

                    let payload = {
                        to_user_id: this.otherId,
                        message: this.messageToSend
                    };

                    let self = this;
                    axios.post(this.sendMessageEndpoint, payload)
                        .then(function (response) {
                            if(response.data.success){
                                self.messages.push(response.data.message);
                                self.scrollToBottom()
                            }

                            self.sendingMessage = false;
                        })
                        .catch(function (error) {
                            toastr.error('Failed to send message');
                            self.sendingMessage = false;
                        });

                    this.messageToSend = "";
                }
            },
            scrollToBottom(){
                this.$nextTick(function(){
                    $('#message-list').scrollTop($('#message-list')[0].scrollHeight);
                });

            }
        },
        mounted() {
            let self = this;

            if(this.messagesProp){
                this.messages = this.messagesProp;
                this.scrollToBottom();
            }

            Echo.private('chat-' + this.ownId)
                .listen('MessageSent', (e) => {
                    self.messages.push(e.message);
                    self.scrollToBottom();
                    self.newMessageSound.play();
                });
        }
    }
</script>

<style scoped>
    .messages{
        flex-grow: 1;
        max-height:80%;
    }
    .field{
        height:20%;
    }

    .message-list{
        height: 100%;
        overflow-y: auto;
        list-style: none;
    }

    .message_item{
        display:flex;
    }

    .message_item p{
        flex-grow: 1;
        max-width: 230px;
        background-color: #525252;
        padding-left: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        margin-left: 10px;
        margin-right: 20px;
        border-radius: 10px;
        word-break: break-word;
    }

    /* width */
    .message-list::-webkit-scrollbar {
        width: 4px;
    }

    /* Track */
    .message-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    .message-list::-webkit-scrollbar-thumb {
        background: #424242;
    }

    /* Handle on hover */
    .message-list::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
