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
                </md-tab>
                <!-- Translation tab -->
                <md-tab md-label="English">
                    <h5>Save the story before editing the translations</h5>
                    <table class="table">
                        <colgroup>
                            <col style="width:30%">
                            <col style="width:70%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Japanese</th>
                                <th>English</th>
                            </tr>
                        </thead>
                        <tbody>
<!--                            <tr v-for="phrase in phrasesNotTranslated" :key="phrase.index">-->
<!--                                <td>-->
<!--                                    <p>{{phrase.japanese}}</p>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <md-field>-->
<!--                                        <label>Translation</label>-->
<!--                                        <md-input v-model="newTranslations[phrase.index].translation" />-->
<!--                                    </md-field>-->
<!--                                </td>-->
<!--                            </tr>-->

<!--                            <hr />-->
<!--                            <h2>Already translated</h2>-->

                            <tr v-for="(translation, i) in story.translations">
                                <td>
                                    <p>{{translation.japanese}}</p>
                                </td>
                                <td>
                                    <md-field>
                                        <label>Translation</label>
                                        <md-input v-model="story.translations[i].translation" />
                                    </md-field>
                                </td>
                            </tr>


                        </tbody>
                    </table>
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
                parsedContent: "",
                phrases: [],
                story: {
                    id: -1,
                    title: "",
                    content: "",
                    keywords: "",
                    imageData: "",
                    translations: []
                },
                newTranslations: []
            }
        },
        computed: {
            newPhrases: function(){
                return this.phrases.filter(p => !(this.story.translations.map(translation => translation.japanese).includes(p.japanese))).map(phrase => phrase.japanese);
            }
        },
        methods: {
            save(){
                let payload = {
                    story_id: this.story.id,
                    title: this.story.title,
                    content: this.story.content,
                    keywords: this.story.keywords,
                    image_data: this.story.imageData,
                    translations: this.story.translations,
                    new_phrases: this.newPhrases
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
            setPhrases(parsedContent){
                let soup = new JSSoup(parsedContent);
                let paragraphes = soup.findAll('p');
                var phrases = [];

                for(var i = 0; i < paragraphes.length ; i++){
                    if(paragraphes[i].text.length > 0) {
                        phrases.push({
                            index: i,
                            japanese: paragraphes[i].text,
                        });
                    }
                }

                this.phrases = phrases;
            }
        },
        mounted() {
            if(this.storyProp){
                this.story = _.clone(this.storyProp);
            }

            this.markdownEditor = new SimpleMDE();
            this.markdownEditor.value(this.story.content);

            this.parsedContent = marked(this.markdownEditor.value());
            this.setPhrases(this.parsedContent);

            let self = this;
            this.markdownEditor.codemirror.on("change", function(){
                self.parsedContent = marked(self.markdownEditor.value());
                self.story.content = self.markdownEditor.value();
                self.setPhrases(self.parsedContent);
            });


        }
    }
</script>

<style scoped>

</style>
