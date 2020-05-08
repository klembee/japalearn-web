<template>
    <div>
        <p>Create a new author:</p>
        <md-field>
            <label for="name">Name</label>
            <md-input id="name" v-model="author.name"/>
        </md-field>
        <md-field>
            <label for="bio">Bio</label>
            <md-textarea id="bio" v-model="author.bio">

            </md-textarea>
        </md-field>

        <image-selector
            @image-changed="setProfileImage"
        ></image-selector>

        <md-button @click="save" class="md-primary md-raised">Save</md-button>
    </div>
</template>

<script>
    export default {
        name: "CreateAuthorForm",
        props: {
            saveEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                author: {
                    name: "",
                    imageData: "",
                    bio: ""
                }
            }
        },
        methods: {
            setProfileImage: function(imageData){
                this.author.imageData = imageData;
            },
            save(){
                let payload = this.author;
                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            location.reload();
                        }else{
                            toastr.error('Error while saving author');
                        }
                    })
                    .catch(function(error){
                        toastr.error('Error while saving author');
                    });
            }
        }
    }
</script>

<style scoped>

</style>
