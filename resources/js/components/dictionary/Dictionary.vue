<template>
    <md-content class="dictionary md-elevation-3">
        <md-toolbar class="md-elevation-0">
            <div class="row">
                <div class="col-12 mt-3">
                    <h3 class="md-title">Japanese dictionary</h3>
                </div>
                <div class="col-12">
                    <md-field class="mr-2">
                        <label>Search...</label>
                        <md-input @input="search()" v-model="searchQuery"></md-input>
                    </md-field>
                </div>
            </div>

            <div class="md-toolbar-row d-none d-sm-block">
                <md-switch @change="search()" v-model="convertToHiragana">Convert to hiragana</md-switch>
                <md-field>
                    <label for="searchIn">Search in</label>
                    <md-select @md-selected="search()" v-model="searchIn" id="searchIn">
                        <md-option value="all">All fields</md-option>
                        <md-option value="reading">Readings</md-option>
                        <md-option value="meaning">Meanings</md-option>
                    </md-select>
                </md-field>
            </div>
        </md-toolbar>

        <!-- Result -->
        <div class="results" v-if="lastQuery">
            <p class="result_for_indication">Results for: {{lastQuery}}</p>
            <md-table class="mt-2">
                <md-table-row v-for="result in results" :key="result.id">
                    <md-table-cell>
                        <p class="dictionary-word"><ruby>{{result.word}}<rt v-if="result.readings">{{result.readings[0].writing}}</rt></ruby></p>
                    </md-table-cell>
                    <md-table-cell>
                        <div class="md-list-item-text">
                            <!-- Meanings -->
                            <p><b>{{result.meanings.map(meaning => meaning.meaning).slice(0, 4).join(", ")}}</b></p>
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
        </div>
        <div v-else>
            <md-empty-state
                md-icon="search"
                md-label="Search a word"
                md-description="Search a word in the search bar to get the meanings and readings">
            </md-empty-state>
        </div>

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
                default: function(){
                    return []
                }
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
                userVocabulary: [],
                convertToHiragana: false,
                searchIn: 'all',
                lastQuery: null
            }
        },
        methods: {
            inUserVocab(vocabulary){
                return this.userVocabulary.map(voc => voc.id).includes(vocabulary.id);
            },
            search: _.debounce(function(){
                if(!this.searchQuery || this.searchQuery == ''){
                    return
                }

                let data = {
                    query: this.searchQuery,
                    convertToHiragana: this.convertToHiragana,
                    field: this.searchIn
                };

                let self = this;
                axios.post(this.queryApiEndpoint, data)
                    .then(function(response){
                        console.log(response);

                        self.currentPage = response.data.current_page;
                        self.firstPageUrl = response.data.first_page_url;
                        self.lastPageUrl = response.data.last_page_url;
                        if(response.data.next_page_url){
                            self.nextPageUrl = response.data.next_page_url;
                        }
                        if(response.data.prev_page_url){
                            self.prevPageUrl = response.data.prev_page_url;
                        }

                        console.log(response)
                        self.lastQuery = response.data.query;
                        self.results = response.data.response;
                        self.total = response.data.total;
                    })
                    .catch(function(error){
                        toastr.error('Error querying dictionary');
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
                        }else{
                            toastr.error('Error while adding to list');
                        }
                    })
                    .catch(function(error){
                        toastr.error('Error while adding to list');
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
    .result_for_indication{
        font-size: 1.3em;
        margin-top: 20px;
    }

    .results{
        padding-left: 20px;
        padding-bottom: 20px;
        padding-right: 20px;
    }

    .dictionary{
        border: 1px solid #c5c5c5;
    }

    /deep/ .md-table-content table{
        table-layout: fixed;
    }
</style>
