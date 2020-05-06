<template>
    <div>
        <md-button @click="showModal = true" class="md-raised md-primary">Edit</md-button>
        <md-dialog :md-active.sync="showModal">
            <md-dialog-title>Edit {{kana.kana}}</md-dialog-title>
            <md-dialog-content>
                <md-field>
                    <label for="mnemonic">Mnemonic</label>
                    <md-textarea id="mnemonic" v-model="kana.mnemonic">

                    </md-textarea>
                </md-field>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button @click="showModal = false">Cancel</md-button>
                <md-button @click="save" class="md-raised md-primary">Save</md-button>
            </md-dialog-actions>
        </md-dialog>
    </div>
</template>

<script>
    export default {
        name: "EditKanaModal",
        props: {
            kanaProp: {
                type: Object,
                required: true
            },
            saveEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                kana: {
                    kana_id: -1,
                    kana: "",
                    mnemonic: ""
                },
                showModal: false
            }
        },
        methods: {
            save(){
                let payload = {
                    mnemonic: this.kana.mnemonic
                };

                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        location.reload();
                    })
                    .catch(function(error){
                        console.log("Error: " + error)
                    });
            }
        },
        mounted() {
            this.kana = _.clone(this.kanaProp);
        }
    }
</script>

<style scoped>
    /deep/ .md-dialog-container {
        width:40%;
    }
</style>
