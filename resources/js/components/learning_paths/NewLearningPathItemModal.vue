<template>
    <div>
        <md-dialog class="the_dialog" :md-active.sync="showDialog">
            <md-dialog-title>New learning path item</md-dialog-title>

            <md-field>
                <label for="word">Word</label>
                <md-input v-model="word" placeholder="大" name="vocabulary_id" id="word" />
            </md-field>

            <md-field>
                <label for="level">Level</label>
                <md-input v-model="level" type="number" min="1" step="1" name="level" id="level" />
            </md-field>

            <md-field>
                <label for="word_type">Type</label>
                <md-select v-model="wordType" name="word_type" id="word_type">
                    <md-option value="radical">Radical</md-option>
                    <md-option value="kanji">Kanji</md-option>
                    <md-option value="vocabulary">Vocabulary</md-option>
                </md-select>
            </md-field>

            <div class="mb-3">
                <p>Meanings: </p>
                <Multiselect
                    v-model="meanings"
                    :options="[]"
                    :allow-empty="false"
                    tag-placeholder="Add meaning"
                    placeholder="Add meaning"
                    :taggable="true"
                    :multiple="true"
                    @tag="addMeaning"

                >
                </Multiselect>
            </div>

            <div>
                <p>Readings: </p>
                <Multiselect
                    v-model="readings"
                    :options="[]"
                    :allow-empty="true"
                    tag-placeholder="Add reading"
                    placeholder="Add reading"
                    :taggable="true"
                    :multiple="true"
                    @tag="addReading"
                >
                </Multiselect>
            </div>

            <div>
                <md-dialog-actions>
                    <md-button @click="showDialog = false">Cancel</md-button>
                    <md-button @click="save()">Create</md-button>
                </md-dialog-actions>
            </div>

        </md-dialog>

        <md-button @click="showDialog = true">New word</md-button>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        name: "NewLearningPathItemModal",
        components: {
            Multiselect
        },
        props: {
            createApiEndpoint: {
                required: true,
                type: String
            },
            wordSearchApiEndpoint: {
                required: true,
                type: String
            }
        },
        data: function(){
            return {
                showDialog: false,
                word: "",
                wordId: -1,
                wordType: 'radical',
                level: 1,
                meanings: [],
                readings: [],
            }
        },
        methods: {
            save(){
                //submit form
                let data = {
                    word: this.word,
                    meanings: this.meanings,
                    readings: this.readings,
                    level: this.level,
                    type: this.wordType
                };

                axios.post(this.createApiEndpoint, data)
                    .then(function(response){
                        let success = response.data.success;
                        if(success){
                            location.reload()
                        }else{
                            //todo: Display on front-end
                            console.log(response.data.message)
                        }
                    })
                    .catch(function(error){
                        console.log("Error while saving item")
                    })
            },
            addMeaning(meaning){
                this.meanings.push(meaning);
            },
            addReading(reading){
                this.readings.push(reading);
            }
        }
    }
</script>

<style scoped>
    .the_dialog{
        width:30rem;
        padding-left: 30px;
        padding-right: 30px;
    }
</style>
