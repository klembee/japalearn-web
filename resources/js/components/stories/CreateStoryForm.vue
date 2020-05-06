<template>
    <div class="row">
        <div class="col-6">
            <md-field>
                <label for="title">Title</label>
                <md-input id="title" v-model="story.title"/>
            </md-field>

            <textarea>

            </textarea>

            <md-field>
                <label for="keywords">Keywords</label>
                <md-input id="keywords" v-model="story.keywords"/>
            </md-field>

            <md-button @click="save" class="md-primary md-raised">Save</md-button>
        </div>
        <div class="col-6">
            <h1>{{story.title}}</h1>
            <div v-html="parsedContent">

            </div>
        </div>
    </div>
</template>

<script>
    import marked from "marked";

    export default {
        name: "CreateStoryForm",
        props: {
            saveEndpoint: {
                type: String,
                required: true
            },
            storyProp: {
                type: Object,
                required: false
            }
        },
        data: function(){
            return {
                markdownEditor: {},
                parsedContent: "",
                story: {
                    id: -1,
                    title: "",
                    content: "",
                    keywords: ""
                }
            }
        },
        methods: {
            save(){
                let payload = {
                    story_id: this.story.id,
                    title: this.story.title,
                    content: this.story.content,
                    keywords: this.story.keywords
                };

                console.log(payload);

                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            // Redirect to story
                            window.location.href = response.data.story_url;
                        }else{
                            console.log("Error while saving story");
                        }
                    })
                    .catch(function(error){
                        console.log("Error while saving story")
                    });
            }
        },
        mounted() {
            if(this.storyProp){
                this.story = _.clone(this.storyProp);
            }

            this.markdownEditor = new SimpleMDE();
            this.markdownEditor.value(this.story.content);

            this.parsedContent = marked(this.markdownEditor.value());

            let self = this;
            this.markdownEditor.codemirror.on("change", function(){
                self.parsedContent = marked(self.markdownEditor.value());
                self.story.content = self.markdownEditor.value();
            });
        }
    }
</script>

<style scoped>

</style>
