<template>
    <div>
        <md-dialog class="the_dialog" :md-active.sync="showDialog">
            <md-dialog-title>New learning path item</md-dialog-title>

            <form method="POST" :action="createApiEndpoint">
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
            </form>

            <md-dialog-actions>
                <md-button @click="showDialog = false">Cancel</md-button>
                <md-button @click="save()">Create</md-button>
            </md-dialog-actions>
        </md-dialog>

        <md-button @click="showDialog = true">New level</md-button>
    </div>
</template>

<script>
    export default {
        name: "NewLearningPathItemModal",
        props: {
            createApiEndpoint: {
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
                level: 1
            }
        },
        methods: {
            save(){
                //submit form
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
