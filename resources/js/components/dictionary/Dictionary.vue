<template>
    <md-content>
        <md-toolbar>
            <div class="md-toolbar-row">
                <div class="md-toolbar-section-start">
                    <h3 class="md-title">Search for a word</h3>
                </div>
                <div class="md-toolbar-section-end">
                    <md-field>
                        <label>Search...</label>
                        <md-input @input="search()" v-model="searchQuery"></md-input>
                    </md-field>
                </div>
            </div>
        </md-toolbar>

        <!-- Result -->
        <md-table class="dictionary mt-2">
            <md-table-row v-for="result in results" :key="result.id">
                <md-table-cell>
                    <p class="dictionary-word"><ruby>{{result.word}}<rt>{{result.writings[0].writing}}</rt></rt></ruby></p>
                </md-table-cell>
                <md-table-cell>
                    <div class="md-list-item-text">
                        <!-- Meanings -->
                        <p><b>{{result.meanings.map(meaning => meaning.meaning).slice(0, 4).join(", ")}}</b></p>

                        <!-- Part of speech -->
                        <p>{{result.pos.map(pos => pos.pos).join(", ")}}</p>
                    </div>
                </md-table-cell>
                <md-table-cell v-if="isStudent">

                    <md-button v-if="inUserVocab(result)">
                        <md-icon>check</md-icon>
                    </md-button>
                    <md-button v-else @click="addToList(result)">
                        <md-icon>add_box</md-icon>
                    </md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
    </md-content>
</template>

<script>
    export default {
        name: "Dictionary",
        props: {
            queryApiEndpoint: {
                required: true,
                type: String
            },
            vocabularyAddApiEndpoint: {
                required: true,
                type: String
            },
            userVocabularyProp: {
                type: Array,
                default: []
            },
            isStudent: {
                type: Boolean,
                default: false
            }
        },
        data: function(){
            return {
                searchQuery: "",
                currentPage: 0,
                firstPageUrl: "",
                lastPageUrl: "",
                nextPageUrl: "",
                prevPageUrl: "",
                total: 0,
                results: [],
                userVocabulary: []
            }
        },
        methods: {
            inUserVocab(vocabulary){
                return this.userVocabulary.map(voc => voc.id).includes(vocabulary.id);
            },
            search: _.debounce(function(){
                let data = {
                    query: this.searchQuery
                };

                let self = this;
                axios.post(this.queryApiEndpoint, data)
                    .then(function(response){
                        self.currentPage = response.data.current_page;
                        self.firstPageUrl = response.data.first_page_url;
                        self.lastPageUrl = response.data.last_page_url;
                        if(response.data.next_page_url){
                            self.nextPageUrl = response.data.next_page_url;
                        }
                        if(response.data.prev_page_url){
                            self.prevPageUrl = response.data.prev_page_url;
                        }

                        self.results = response.data.data;
                        self.total = response.data.total;
                    })
                    .catch(function(error){
                        console.log("Error querying dictionary")
                    })
            }, 400),
            addToList(vocabulary){
                let self = this;
                let data = {
                    vocabulary_id: vocabulary.id
                };
                axios.post(this.vocabularyAddApiEndpoint, data)
                    .then(function(response){
                        if(!response.data.error){
                            // Add to the vocabulary
                            self.userVocabulary.push(response.data)
                        }
                    })
                    .catch(function(error){
                        console.log("Error while adding to list")
                    })
            }
        },
        mounted() {
            this.userVocabulary = _.clone(this.userVocabularyProp)
        }
    }
</script>

<style scoped>
    .dictionary-word{
        font-size:2.5em;
        margin-right:2rem;
        margin-bottom:0;
    }
</style>
