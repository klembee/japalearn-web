<template>
    <div class="row">
        <div class="col-6">

            <md-tabs>
                <!-- Japanese writing -->
                <md-tab md-label="Japanese">
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

                    <image-selector
                        :aspect-ratio="16/9"
                        @image-changed="imageChanged">

                    </image-selector>

                    <md-field>
                        <label>Description</label>
                        <md-textarea v-model="story.description">

                        </md-textarea>
                    </md-field>

                    <md-field>
                        <label>META Description</label>
                        <md-textarea v-model="story.meta_description">

                        </md-textarea>
                    </md-field>

                    <hr />
                    <h2>Vocab</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Word</th>
                            <th>Reading</th>
                            <th>Meaning</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vocab, idx) in story.vocab" :key="vocab.word">
                            <td>
                                <p>{{vocab.word}}</p>
                            </td>
                            <td>
                                <p>{{vocab.reading}}</p>
                            </td>
                            <td>
                                <p>{{vocab.meaning}}</p>
                            </td>
                            <td>
                                <md-button @click="deleteVocab(idx)" class="md-icon-button">
                                    <md-icon>delete</md-icon>
                                </md-button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <md-field>
                                    <label>Word</label>
                                    <md-input v-model="newVocab.word"/>
                                </md-field>
                            </td>
                            <td>
                                <md-field>
                                    <label>Reading</label>
                                    <md-input v-model="newVocab.reading"/>
                                </md-field>
                            </td>
                            <td>
                                <md-field>
                                    <label>Meaning</label>
                                    <md-input v-model="newVocab.meaning"/>
                                </md-field>
                            </td>
                            <td>
                                <md-button @click="addVocab" class="md-raised md-accent">Add</md-button>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </md-tab>
                <!-- Translation tab -->
                <md-tab md-label="English">
                    <textarea id="translation-editor">

                    </textarea>
                </md-tab>
            </md-tabs>


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
                translationEditor: {},
                parsedContent: "",
                phrases: [],
                story: {
                    id: -1,
                    title: "",
                    content: "",
                    translated_content: "",
                    keywords: "",
                    imageData: "",
                    description: "",
                    meta_description: "",
                    vocab: []
                },
                newVocab: {
                    word: "",
                    reading: "",
                    meaning: ""
                }
            }
        },
        computed: {
        },
        methods: {
            save(){
                let payload = {
                    story_id: this.story.id,
                    title: this.story.title,
                    content: this.story.content,
                    keywords: this.story.keywords,
                    image_data: this.story.imageData,
                    translated_content: this.story.translated_content,
                    description: this.story.description,
                    meta_description: this.story.meta_description,
                    vocab: this.story.vocab
                };

                axios.post(this.saveEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            // Redirect to story
                            window.location.href = response.data.story_url;
                        }else{
                            toastr.error("Error while saving story");
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while saving story");
                    });
            },
            imageChanged(dataurl){
                this.story.imageData = dataurl;
            },
            addVocab(){
                this.story.vocab.push({
                    word: this.newVocab.word,
                    reading: this.newVocab.reading,
                    meaning: this.newVocab.meaning
                });

                this.newVocab.word = "";
                this.newVocab.reading = "";
                this.newVocab.meaning = "";
            },
            deleteVocab(idx){
                this.$delete(this.story.vocab, idx)
            }
        },
        mounted() {
            if (this.storyProp) {
                this.story = _.clone(this.storyProp);
            }

            this.markdownEditor = new SimpleMDE();
            this.markdownEditor.value(this.story.content);

            this.translationEditor = new SimpleMDE({element: document.getElementById("translation-editor")});

            if (this.story.translated_content){
                this.translationEditor.value(this.story.translated_content);
            }

            this.parsedContent = marked(this.markdownEditor.value());

            let self = this;
            this.markdownEditor.codemirror.on("change", function(){
                self.parsedContent = marked(self.markdownEditor.value());
                self.story.content = self.markdownEditor.value();
            });

            this.translationEditor.codemirror.on("change", function(){
                self.story.translated_content = self.translationEditor.value();
            });


        }
    }
</script>

<style scoped>

</style>
