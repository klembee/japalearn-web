<template>
    <md-snackbar md-position="center" :md-active.sync="showSnackBar" md-persistent>
        <span>{{message}}</span>
        <md-button class="md-primary" @click="showSnackBar = false">Close</md-button>
    </md-snackbar>
</template>

<script>
    export default {
        name: "FlashSnackBar",
        props: {
            message: {
                required: true,
                type: String,
            }
        },
        data: function(){
            return {
                showSnackBar: false
            }
        },
        mounted() {
            this.showSnackBar = true;

            let self = this;
            setTimeout(function(){
                self.showSnackBar = false;
            }, 4000)
        }
    }
</script>

<style scoped>

</style>
