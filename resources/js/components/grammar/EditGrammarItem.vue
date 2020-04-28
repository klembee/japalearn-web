<template>
    <div class="row">
        <div class="col-md-6 col-12">
            <h2>Editing lesson</h2>
            <md-field>
                <label for="title">Title</label>
                <md-input id="title" v-model="item.title"/>
            </md-field>

            <label for="content">Content</label>
            <textarea id="content">

            </textarea>
            <md-button @click="save" class="md-raised md-primary">Save</md-button>
        </div>
        <div class="col-md-6 col-12">
            <h2>Result</h2>
            <div id="result">
                <span v-html="parsedContent"></span>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    </div>
</template>

<script>
    import SimpleMDE from "SimpleMDE";
    import marked from "marked";

    export default {
        name: "EditGrammarItem",
        props: {
            itemProp: {
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
                item: {
                    title: "",
                    content: ""
                },
                markdownEditor: {},
                parsedContent: ""
            }
        },
        computed: {

        },
        methods: {
            save(){
                let payload = {
                    title: this.item.title,
                    content: this.markdownEditor.value()
                };

                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            console.log("SAVED !");
                        }else{
                            console.log("Error while saving grammar item")
                            //todo (Jonathan): Show error to user
                        }
                    })
                    .catch(function(error){
                        console.log("Error while saving grammar item")
                        //todo (Jonathan): Show error to user
                    })
            }
        },
        mounted() {
            this.item = _.clone(this.itemProp);
            this.markdownEditor = new SimpleMDE();

            this.markdownEditor.value(this.item.content);
            this.parsedContent = marked(this.markdownEditor.value());


            let self = this;
            this.markdownEditor.codemirror.on("change", function(){
                self.parsedContent = marked(self.markdownEditor.value());
            });
        }
    }
</script>

<style scoped>

</style>
