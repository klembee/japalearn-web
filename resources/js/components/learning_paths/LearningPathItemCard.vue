<template>
    <md-card v-if="!deleted" class="mb-4 col-md-2 col-sm-4 col-6 vocab_learning_path_view_item" md-with-hover>
        <p class="word_title">{{itemProp.word}}</p>
        <p class="word_meaning" v-if="itemProp.meanings[0]">{{itemProp.meanings[0].meaning}}</p>

        <md-card-actions>
            <md-button @click="deleteItem()" class="md-icon-button">
                <md-icon>delete</md-icon>
            </md-button>
            <md-button @click="edit()" class="md-icon-button">
                <md-icon>edit</md-icon>
            </md-button>
        </md-card-actions>

        <!-- The edit dialog -->
        <md-dialog class="update-dialog" :md-active.sync="showEditForm">
            <md-dialog-title>Editing {{itemProp.word}}</md-dialog-title>
            <md-dialog-content>
                <md-field>
                    <label>Word</label>
                    <md-input v-model="update.word"></md-input>
                </md-field>

                <md-field>
                    <label for="word_type">Type</label>
                    <md-select v-model="update.wordTypeId" name="word_type" id="word_type">
                        <md-option value="1">Radical</md-option>
                        <md-option value="2">Kanji</md-option>
                        <md-option value="3">Vocabulary</md-option>
                    </md-select>
                </md-field>

                <div class="mb-3">
                    <p>Meanings: </p>
                    <Multiselect
                        v-model="update.meanings"
                        :options="[]"
                        label="meaning"
                        :allow-empty="true"
                        tag-placeholder="Add meaning"
                        placeholder="Add meaning"
                        track-by="meaning"
                        :taggable="true"
                        :multiple="true"
                        @tag="addMeaning"

                    >
                    </Multiselect>
                </div>

                <div class="mb-3">
                    <p>Readings: </p>
                    <Multiselect
                        v-model="update.readings"
                        :options="[]"
                        label="reading"
                        :allow-empty="true"
                        tag-placeholder="Add reading"
                        placeholder="Add reading"
                        track-by="reading"
                        :taggable="true"
                        :multiple="true"
                        @tag="addReading"
                    >
                    </Multiselect>
                </div>

                <!-- Mnemonic -->
                <md-field>
                    <label>Mnemonic</label>
                    <md-textarea v-model="update.mnemonic">

                    </md-textarea>
                </md-field>

                <p>Examples:</p>
                <div>
                    <md-table>
                        <b-thead>
                            <tr>
                                <th>Example</th>
                                <th>Translation</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </b-thead>
                        <b-tbody>
                            <tr v-for="example in update.examples" :key="example.example">
                                <td>
                                    {{example.example}}
                                </td>
                                <td>
                                    {{example.translation}}
                                </td>
                                <td>
                                    {{example.type}}
                                </td>
                            </tr>

                        </b-tbody>

                        <b-tfoot>
                            <!-- Add form -->
                            <tr>
                                <td>
                                    <md-field>
                                        <label>Example</label>
                                        <md-input v-model="newExample.example"/>
                                    </md-field>
                                </td>
                                <td>
                                    <md-field>
                                        <label>Translation</label>
                                        <md-input v-model="newExample.translation"/>
                                    </md-field>
                                </td>
                                <td>
                                    <md-field>
                                        <label>Type</label>
                                        <md-select v-model="newExample.type">
                                            <md-option value="phrase">Phrase</md-option>
                                            <md-option value="vocabulary">Vocabulary</md-option>
                                        </md-select>
                                    </md-field>
                                </td>
                                <td>
                                    <md-button @click="addExample()">Add</md-button>
                                </td>
                            </tr>
                        </b-tfoot>
                    </md-table>
                </div>

            </md-dialog-content>
            <md-dialog-actions>
                <md-button @click="showEditForm = false">Cancel</md-button>
                <md-button @click="save()">Save</md-button>
            </md-dialog-actions>
        </md-dialog>
    </md-card>

</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "LearningPathItemCard",
        components: {
            Multiselect
        },
        props: {
            updateEndpoint: {
                type: String,
                required: true
            },
            deleteEndpoint: {
                type: String,
                required: true
            },
            itemProp: {
                type: Object,
                required: true
            },
        },
        data: function(){
            return {
                showEditForm: false,
                item: {},
                deleted: false,
                update: {
                    word: "",
                    wordTypeId: 0,
                    meanings: [],
                    readings: [],
                    mnemonic: "",
                    examples: [],
                },
                newExample: {
                    example: "",
                    translation: "",
                    type: "phrase"
                }
            }
        },
        methods: {
            edit(){
                this.showEditForm = true
            },
            deleteItem(){
                let self = this;
                axios.post(this.deleteEndpoint)
                    .then(function(response){
                        if(response.data.success){
                            console.log("Successfuly deleted item");

                            //Remove this component from the DOM
                            self.deleted = true

                        }else{
                            toastr.error("Error while deleting item");
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while deleting item");
                    })
            },
            save(){
                let payload = {
                    word: this.update.word,
                    word_type_id: this.update.wordTypeId,
                    mnemonic: this.update.mnemonic,
                    examples: this.update.examples,
                    meanings: this.update.meanings,
                    readings: this.update.readings,
                };

                console.log(payload);

                let self = this;
                axios.post(this.updateEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            console.log("updated successfuly");
                            location.reload();
                        }else{
                            toastr.error("Error while updating item: " + response.data.message);
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while updating item");
                    });
            },
            addMeaning(meaning){
                this.update.meanings.push({meaning: meaning});
            },
            addReading(reading){
                this.update.readings.push({reading: reading});
            },
            addExample(){
                this.update.examples.push({
                    example: this.newExample.example,
                    translation: this.newExample.translation,
                    type: this.newExample.type
                });

                // Reset the new example
                this.newExample = {
                    example: "",
                    translation: "",
                    type: "phrase"
                };
            }
        },
        mounted() {
            this.item = _.clone(this.itemProp);

            // Copy the item to the update object
            this.update.word = this.item.word;
            this.update.wordTypeId = this.item.word_type_id;
            this.update.meanings = this.item.meanings;
            this.update.readings = this.item.readings;
            this.update.mnemonic = this.item.mnemonic;
            this.update.examples = this.item.examples;
        }
    }
</script>

<style scoped>
    .update-dialog{
        /*width: 30%;*/
    }
</style>
