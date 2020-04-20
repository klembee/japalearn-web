<template>
    <div>
        <md-subheader>{{title}}</md-subheader>
        <md-field>
            <label>{{label}}</label>
            <md-file @md-change="loadImage" id="file_selector"/>
        </md-field>

        <!-- todo: here -->
        <input v-if="croppedData" :value="croppedData" type="hidden" :name="inputName"/>

        <!-- Preview and crop -->
        <div class="row">

            <!-- Cropper -->
            <div class="col-md-6" style="width:400px;" v-show="imageData">
                <img id="preview-image" :src="imageData" />
            </div>

            <!-- Preview of the crop -->
            <div v-show="croppedData" class="col-md-6">
                <img :src="croppedData" class="crop-preview"/>
            </div>
        </div>


        <link  href="/css/cropper.css" rel="stylesheet">
    </div>
</template>

<script>
    let Cropper =  require('cropperjs');
    export default {
        name: "ImageSelector",
        props: {
            inputName: String,
            title: String,
            label: String
        },
        data: function(){
            return {
                cropper: null,
                imageData: null,
                croppedData: null,
            }
        },
        methods: {
            loadImage(images){
                if(images.length > 0) {
                    let image = images[0]
                    var reader = new FileReader()

                    let self = this;
                    reader.onload = (function(the_file) {
                        return function(e){
                            self.imageData = reader.result;
                            self.$nextTick(function(){
                                self.startCropper();
                            })
                        }
                    })(image);

                    reader.readAsDataURL(image)
                }
            },
            startCropper(){
                let previewImage = document.getElementById('preview-image');
                let self = this;
                this.cropper = new Cropper(previewImage, {
                    aspectRatio: 1,
                    cropend(event){
                        console.log(event);
                        self.croppedData = self.cropper.getCroppedCanvas().toDataURL();
                    }
                });
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>
    #preview-image{
        max-width:250px;
    }
    .crop-preview{
        width: 50%;
        margin: auto;
        display: block;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
</style>
