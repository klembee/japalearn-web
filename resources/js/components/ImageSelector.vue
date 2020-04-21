<template>
    <div>
        <md-subheader>{{title}}</md-subheader>
        <md-field>
            <label>{{label}}</label>
            <md-file @md-change="loadImage" id="file_selector"/>
        </md-field>

        <!-- todo: here -->
        <input v-if="croppedData" id="cropped_image" :value="croppedData" type="hidden" :name="inputName"/>

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
                    ready(event){
                        self.addImageToForm();
                    },
                    cropend(event){
                        self.addImageToForm();
                    }
                });
            },
            dataURItoBlob(dataURI){
                // THANKS TO : https://stackoverflow.com/a/12300351/3971619
                // convert base64 to raw binary data held in a string
                // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
                var byteString = atob(dataURI.split(',')[1]);

                // separate out the mime component
                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

                // write the bytes of the string to an ArrayBuffer
                var ab = new ArrayBuffer(byteString.length);

                // create a view into the buffer
                var ia = new Uint8Array(ab);

                // set the bytes of the buffer to the correct values
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }

                // write the ArrayBuffer to a blob, and you're done
                return new Blob([ab], {type: mimeString});

            },
            addImageToForm(){
                this.croppedData = this.cropper.getCroppedCanvas().toDataURL();
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
