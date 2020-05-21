<template>
    <md-card v-if="!deleted" class="mb-4 col-md-2 col-sm-4 col-6 vocab_learning_path_view_item" md-with-hover>
        <!-- todo: Give indication if no mnemonic  -->
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
                    <label>Level</label>
                    <md-input v-model="update.level"></md-input>
                </md-field>

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

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Meaning</th>
                            <th>Is main ?</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(meaning, index) in update.meanings" :key="meaning.meaning">
                            <td>{{meaning.meaning}}</td>
                            <td>
                                <input type="checkbox" v-model="meaning.is_main"/>

                            </td>
                            <td>
                                <md-button @click="removeMeaning(meaning)">
                                    <md-icon>
                                        delete
                                    </md-icon>
                                </md-button>

                            </td>
                        </tr>
                        <md-field>
                            <label>Meaning</label>
                            <md-input v-model="newMeaning"/>
                        </md-field>
                        <md-button @click="addMeaning" class="md-raised md-accent">Add</md-button>
                        </tbody>
                    </table>

                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <p>On readings: </p>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Reading</th>
                                <th>Is main ?</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(reading, index) in update.onReadings" :key="reading.reading">
                                <td>{{reading.reading}}</td>
                                <td>
                                    <input type="checkbox" v-model="reading.is_main"/>

                                </td>
                                <td>
                                    <md-button @click="removeOnReading(reading)">
                                        <md-icon>
                                            delete
                                        </md-icon>
                                    </md-button>

                                </td>
                            </tr>
                            <md-field>
                                <label>Reading</label>
                                <md-input v-model="newOnReading"/>
                            </md-field>
                            <md-button @click="addOnReading" class="md-raised md-accent">Add</md-button>
                            </tbody>
                        </table>

<!--                        <Multiselect-->
<!--                            v-model="update.onReadings"-->
<!--                            :options="[]"-->
<!--                            :allow-empty="true"-->
<!--                            tag-placeholder="Add reading"-->
<!--                            placeholder="Add reading"-->
<!--                            :taggable="true"-->
<!--                            :multiple="true"-->
<!--                            @tag="addOnReading"-->
<!--                        >-->
<!--                        </Multiselect>-->
                    </div>

                    <div class="col-6">
                        <p>Kun readings: </p>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Reading</th>
                                    <th>Is main ?</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="reading in update.kunReadings" :key="reading.reading">
                                    <td>{{reading.reading}}</td>
                                    <td>
                                        <input v-model="reading.is_main" type="checkbox"/>

                                    </td>
                                    <td>
                                        <md-button @click="removeKunReading(reading)">
                                            <md-icon>
                                                delete
                                            </md-icon>
                                        </md-button>

                                    </td>
                                </tr>
                                <md-field>
                                    <label>Reading</label>
                                    <md-input v-model="newKunReading"/>
                                </md-field>
                                <md-button @click="addKunReading" class="md-raised md-accent">Add</md-button>
                            </tbody>
                        </table>

<!--                        <Multiselect-->
<!--                            v-model="update.kunReadings"-->
<!--                            :options="[]"-->
<!--                            :allow-empty="true"-->
<!--                            tag-placeholder="Add reading"-->
<!--                            placeholder="Add reading"-->
<!--                            :taggable="true"-->
<!--                            :multiple="true"-->
<!--                            @tag="addKunReading"-->
<!--                        >-->
<!--                        </Multiselect>-->
                    </div>
                </div>



                <!-- Mnemonic -->
                <md-field>
                    <label>Meaning mnemonic</label>
                    <md-textarea v-model="update.meaning_mnemonic">

                    </md-textarea>
                </md-field>
                <md-field>
                    <label>Reading mnemonic</label>
                    <md-textarea v-model="update.reading_mnemonic">

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
                    onReadings: [],
                    kunReadings: [],
                    meaning_mnemonic: "",
                    reading_mnemonic: "",
                    examples: [],
                },
                newExample: {
                    example: "",
                    translation: "",
                    type: "phrase"
                },
                newKunReading: "",
                newOnReading: "",
                newMeaning: ""
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
                    meaning_mnemonic: this.update.meaning_mnemonic,
                    reading_mnemonic: this.update.reading_mnemonic,
                    examples: this.update.examples,
                    meanings: this.update.meanings,
                    onReadings: this.update.onReadings,
                    kunReadings: this.update.kunReadings,
                    level: this.update.level
                };

                let self = this;
                axios.post(this.updateEndpoint, payload)
                    .then(function(response){
                        if(response.data.success){
                            console.log("updated successfuly");
                            // location.reload();
                            self.showEditForm = false
                        }else{
                            toastr.error("Error while updating item: " + response.data.message);
                        }
                    })
                    .catch(function(error){
                        toastr.error("Error while updating item");
                    });
            },
            addMeaning(){
                this.update.meanings.push({
                    meaning: this.newMeaning,
                    is_main: 0
                });
            },
            addOnReading(){
                this.update.onReadings.push({
                    reading: this.newOnReading,
                    is_main: 0
                });

                this.newOnReading = "";
            },
            addKunReading(){
                this.update.kunReadings.push({
                    reading: this.newKunReading,
                    is_main: 0
                });

                this.newKunReading = "";
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
            },
            removeOnReading(reading){
                this.update.onReadings = this.update.onReadings.filter(item => item !== reading)
            },
            removeKunReading(reading){
                this.update.kunReadings = this.update.kunReadings.filter(item => item !== reading)
            },
            removeMeaning(meaning){
                this.update.meanings = this.update.meanings.filter(item => item !== meaning)
            }
        },
        mounted() {
            this.item = _.clone(this.itemProp);

            // Copy the item to the update object
            this.update.word = this.item.word;
            this.update.wordTypeId = this.item.word_type_id;
            this.update.meanings = this.item.meanings;
            this.update.kunReadings = this.item.kun_readings;
            this.update.onReadings = this.item.on_readings;
            this.update.meaning_mnemonic = this.item.meaning_mnemonic;
            this.update.reading_mnemonic = this.item.reading_mnemonic;
            this.update.examples = this.item.examples;
            this.update.level = this.item.level;
        }
    }
</script>

<style scoped>
    .update-dialog{
        /*width: 30%;*/
    }
</style>
