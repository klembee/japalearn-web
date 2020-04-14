<template>
    <md-card class="mb-4 col-md-2 col-sm-4 col-6 vocab_learning_path_view_item" md-with-hover>
        <p class="word_title">{{itemProp.word}}</p>
        <p class="word_meaning">{{itemProp.meanings[0].meaning}}</p>

        <md-card-actions>
            <md-button @click="edit()" class="md-icon-button">
                <md-icon>edit</md-icon>
            </md-button>
        </md-card-actions>

        <!-- The edit dialog -->
        <md-dialog :md-active.sync="showEditForm">
            <md-dialog-title>Editing {{itemProp.word}}</md-dialog-title>
            <md-dialog-content>
                <md-field>
                    <label>Word</label>
                    <md-input v-model="item.word"></md-input>
                </md-field>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button @click="showEditForm = false">Cancel</md-button>
                <md-button @click="save()">Save</md-button>
            </md-dialog-actions>
        </md-dialog>
    </md-card>

</template>

<script>
    export default {
        name: "LearningPathItemCard",
        props: {
            itemProp: {
                type: Object,
                required: true
            },
        },
        data: function(){
            return {
                showEditForm: false,
                item: {}
            }
        },
        methods: {
            edit(){
                this.showEditForm = true
            },
            save(){
                return ""
            }
        },
        mounted() {
            this.item = _.clone(this.itemProp)
        }
    }
</script>

<style scoped>

</style>
