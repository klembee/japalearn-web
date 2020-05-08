<template>
    <div>
        <md-button @click="openDialog()">Invite students</md-button>
        <md-dialog class="invitation-dialog" :md-active.sync="showDialog">
            <md-dialog-title>Invite your students</md-dialog-title>
            <p>Send this link to your students !</p>
            <md-content>
                <md-progress-spinner md-mode="indeterminate" v-if="loading"></md-progress-spinner>

                <div class="invitation-content">
                    <md-field>
                        <md-input :value="codeLink" readonly>{{}}</md-input>
                    </md-field>

                    <md-button class="md-icon-button" @click="copyLink()">
                        <md-icon>file_copy</md-icon>
                    </md-button>
                </div>

            </md-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click="showDialog = false">Close</md-button>
            </md-dialog-actions>
        </md-dialog>
    </div>

</template>

<script>
    export default {
        name: "StudentInvidationDialog",
        props: {
            codeGenerationEndpoint: {
                type: String,
                required: true
            },
            codeAcceptLink: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                showDialog: false,
                code: "",
                loading: false
            }
        },
        computed: {
            codeLink: function(){
                return this.codeAcceptLink.replace('THE_CODE', this.code);
            }
        },
        methods: {
            openDialog(){
                this.showDialog = !this.showDialog;
                this.loading = true;
                this.getCode();
            },
            getCode(){
                let self = this;
                axios.get(this.codeGenerationEndpoint)
                    .then(function(response){
                        self.loading = false;
                        self.code = response.data;
                    })
                    .catch(function(error){
                        toastr.error("An error happened.");
                        self.loading = false
                    });
            },
            copyLink(){
                navigator.clipboard.writeText(this.codeLink).then(function() {
                    //todo: Show copied notification
                    console.log("Copied !")
                })
            }
        },
        mounted() {
            this.getCode();
        }
    }
</script>

<style scoped>
    .invitation-content{
        display:flex;
        align-items: center;
    }
    .invitation-dialog{
        width: 40rem;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
