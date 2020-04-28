<template>
    <div>
        <md-button @click="showModal = true">Add grammar lesson</md-button>

        <md-dialog class="dialog" :md-active.sync="showModal">
            <md-dialog-title>Adding grammar lesson</md-dialog-title>
            <md-dialog-content>
                <md-field>
                    <label for="title">Title</label>
                    <md-input id="title" v-model="title"/>
                </md-field>

                <md-field>
                    <label for="content">Content</label>
                    <md-textarea id="content" v-model="content"></md-textarea>
                </md-field>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button @click="showModal = false">Cancel</md-button>
                <md-button @click="save">Save</md-button>
            </md-dialog-actions>
        </md-dialog>
    </div>
</template>

<script>
    export default {
        name: "AddGrammarItemModal",
        props: {
            saveApiEndpoint: {
                type: String,
                required: true
            },
            categoryId: {
                type: Number,
                required: true
            }
        },
        data: function(){
            return {
                showModal: false,
                title: "",
                content: ""
            }
        },
        methods: {
            save(){
                let payload = {
                    title: this.title,
                    content: this.content,
                    category_id: this.categoryId
                };

                axios.post(this.saveApiEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            console.log("Success !");
                            location.reload()
                        }else{
                            console.log("Error: " + response.data.message)
                            //todo (Jonathan): Show message to user
                        }
                    })
                    .catch(function(error){
                        console.log("Error while save grammar lesson !")
                        //todo (Jonathan): Show message to user
                    })
            }
        }
    }
</script>

<style scoped>
    .dialog{
        width:40%;
    }
</style>
