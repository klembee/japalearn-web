<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "flash",
        props: {
            type: {
                type: String,
                default: "success"
            },
            message: {
                type: String,
                required: true
            }
        },
        mounted() {
            if(this.type === "error"){
                toastr.error(this.message);
            }else if(this.type === "success"){
                toastr.success(this.message);
            }
        }
    }
</script>

<style scoped>

</style>
