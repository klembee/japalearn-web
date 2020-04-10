<template>
    <div class="chat-list">
        <div class="chat-header d-flex" @click="minimized = !minimized">
            <h3>Chat</h3>
            <md-icon v-if="minimized" class="m-0">arrow_drop_up</md-icon>
            <md-icon v-else class="m-0">arrow_drop_down</md-icon>
        </div>
        <div v-show="!minimized" class="chat-list-content">
            <md-autocomplete
                class="search mb-0"
                v-model="searchedFriend"
                :md-options="friendNames"
                md-layout="box"
                @md-selected="searchSelected">
                <label>Search...</label>
            </md-autocomplete>
            <md-list>
                <md-list-item class="conversation-item" @click="openConversation(conversation.with_user.id)" v-for="conversation in conversations" :key="conversation.with_user.id">
                    <!-- User avatar -->
                    <md-avatar>
                        <img src="https://randomuser.me/api/portraits/men/22.jpg"/>
                    </md-avatar>
                    <div class="last-message">
                        <p class="mb-1"><b>{{conversation.with_user.name}}</b></p>
                        <p v-if="conversation.last_message" class="mb-0">{{conversation.last_message.message}}</p>
                        <p v-else>Start a new conversation !</p>
                    </div>

                </md-list-item>
                <md-divider class="md-inset"></md-divider>
            </md-list>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChatList",
        props: {
            conversationEndpoint: {
                required: true,
                type: String
            },
            friends: {
                default: function(){
                    return []
                }
            }
        },
        data: function(){
            return {
                conversations: [],
                searchedFriend: null,
                minimized: true
            }
        },
        computed:{
            friendNames: function(){
                return this.friends.map(friend => friend.name);
            }
        },
        methods: {
            fetchConversations(){
                let self = this;
                axios.get(this.conversationEndpoint)
                    .then(function(response){
                        self.conversations = response.data;
                    })
                    .catch(function(error){
                        console.log("Error while fetching conversations");
                    })
            },
            searchSelected(val){
                console.log(val)
            },
            openConversation(friend_id){
                let theConversation = this.conversations.filter(conversation => conversation.with_user.id === friend_id)[0];
                this.$emit('open_conversation', friend_id, theConversation);
            },
        },
        mounted() {
            this.fetchConversations()
        }
    }
</script>

<style scoped>
    .chat-header{
        padding-left: 20px;
        padding-right: 20px;
        justify-content: space-between;
        cursor: pointer;
    }
    .chat-list{
        width: 20rem;
        padding-top: 20px;
        padding-bottom: 5px;
        background: whitesmoke;
        display:inline-block;
        vertical-align: bottom;
    }
    .conversation-item:hover{
        cursor:pointer;
    }

    .chat-list-content{
        height:25rem;
    }

    /deep/ .conversation-item .md-list-item-content{
        justify-content: initial !important;
    }

    .last-message{
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
