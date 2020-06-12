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

<!--            <image-selector-->
<!--                :aspect-ratio="16/9"-->
<!--                @image-changed="imageChanged">-->

<!--            </image-selector>-->

            <md-field>
                <label>Front image url (16/9 ratio)</label>
                <md-input v-model="post.image_url"/>
            </md-field>

            <md-field>
                <label>Small front image url</label>
                <md-input v-model="post.small_image_url"/>
            </md-field>

            <md-field>
                <label>Meta description</label>
                <md-input v-model="post.meta_description"/>
            </md-field>

            <div v-if="authors.length > 0">
                <select v-model="post.author_id">
                    <option :value="author.id" v-for="author in authors" :key="author.id">{{author.name}}</option>
                </select>
            </div>
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
            },
            authors: {
                type: Array,
                required: false
            }
        },
        data: function(){
            return {
                post: {
                    id: -1,
                    title: "",
                    content: "",
                    image_url: "",
                    small_image_url: "",
                    meta_description: "",
                    author_id: null
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
                    image_url: this.post.image_url,
                    small_image_url: this.post.small_image_url,
                    meta_description: this.post.meta_description,
                    author_id: this.post.author_id
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
