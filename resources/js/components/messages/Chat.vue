<template>
    <div class="chat d-flex">
        <chat-window
            ref="chatWindow"
            v-if="currentConversation"
            :conversation="currentConversation"
            :send-message-endpoint="sendMessageEndpoint"
            @close="closeConversation()"
            :key="currentConversation.last_message"
        >
        </chat-window>
        <chat-list
            ref="chatList"
            :conversation-endpoint="conversationEndpoint"
            :friends="friends"
            @open_conversation="openConversation"
        ></chat-list>
    </div>
</template>

<script>
    import ChatList from "./ChatList";
    import ChatWindow from "./ChatWindow";
    export default {
        name: "Chat",
        components: {ChatWindow, ChatList},
        props: {
            conversationEndpoint: {
                required: true,
                type: String
            },
            sendMessageEndpoint: {
                type: String,
                required: true
            },
            friends: {
                default: function(){
                    return []
                }
            },
            currentUserId: {
                required: true
            }
        },
        data: function(){
            return {
                currentConversation: null
            }
        },
        methods: {
            openConversation: function(friend_id, conversation){
                // this.currentConversation = null;
                // this.$nextTick(() => {
                //     this.currentConversation = conversation
                // });
                this.currentConversation = conversation
            },
            closeConversation: function(){
                this.currentConversation = null;
            }
        },
        created() {
            let self = this;

            Echo.private('chat-' + self.currentUserId)
                .listen('MessageSent', (e) => {
                    self.$refs.chatList.openConversation(e.from.id)
                    self.$nextTick(function(){
                        self.$nextTick(function() {
                            self.$refs.chatWindow.newMessage(e.message);
                            newMessageSound.play();
                        })
                    })
                })
        }
    }
</script>

<style scoped>
    .chat{
        position:fixed;
        right:0;
        bottom:0;
        height:25rem;
    }
</style>
