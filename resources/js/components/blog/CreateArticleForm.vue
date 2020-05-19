<template>
    <div class="row">
        <div class="col-6">
            <md-field>
                <label>Title</label>
                <md-input v-model="post.title"/>
            </md-field>

            <label>Content</label>
            <textarea id="content">

            </textarea>

            <image-selector
                :aspect-ratio="16/9"
                @image-changed="imageChanged">

            </image-selector>

            <md-field>
                <label>Meta description</label>
                <md-input v-model="post.meta_description"/>
            </md-field>
        </div>
        <div class="col-6">
            <h1>{{post.title}}</h1>
            <hr/>
            <div v-html="parsedContent">

            </div>

            <md-button @click="save" class="md-primary md-raised">Save</md-button>
        </div>
    </div>
</template>

<script>
    import marked from "marked";

    export default {
        name: "CreateArticleForm",
        props: {
            postProp: {
                type: Object,
            },
            saveEndpoint: {
                type: String,
                required: true
            },
            viewArticleUrl: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                post: {
                    id: -1,
                    title: "",
                    content: "",
                    imageData: "",
                    meta_description: ""
                },
                markdownEditor: {},
                parsedContent: "",
            }
        },
        computed: {
        },
        methods: {
            imageChanged(dataurl){
                this.post.imageData = dataurl;
            },
            save(){
                let payload = {
                    post_id: this.post.id,
                    title: this.post.title,
                    content: this.post.content,
                    image_data: this.post.imageData,
                    meta_description: this.post.meta_description
                };

                console.log(payload);

                let self = this;
                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            window.location.href = self.viewArticleUrl.replace(":id", response.data.article.slug)
                        }else{
                            toastr.error("Failed to create article !")
                        }
                    })
                    .catch(function(error){
                        toastr.error("Failed to create article !")
                    })
            }
        },
        mounted() {
            if(this.postProp) {
                this.post = _.clone(this.postProp);
            }
            this.markdownEditor = new SimpleMDE();

            this.markdownEditor.value(this.post.content);
            this.parsedContent = marked(this.post.content);

            let self = this;
            this.markdownEditor.codemirror.on("change", function(){
                self.parsedContent = marked(self.markdownEditor.value());
                self.post.content = self.markdownEditor.value();
            });
        }
    }
</script>

<style scoped>

</style>
