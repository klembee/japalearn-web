<template>
    <b-tabs class="tabs" v-model="activeTab" align="center">
        <!-- Tab only used for kanjis -->
        <b-tab v-if="item.word_type_id === 2" id="tab-radicals" title="Radicals">
            <!-- Radicals in the kanji -->

        </b-tab>

        <b-tab id="tab-meaning" title="Meaning">
            <div class="row mt-4">
                <div class="col-md-3 col-12">
                    <h3>Type</h3>
                    <p class="text-capitalize font-weight-bold">{{item.type}}</p>
                    <hr/>
                    <h3>Meanings</h3>
                    <ul v-for="meaning in item.meanings" :key="meaning.id">
                        <li class="text-capitalize">{{meaning.meaning}}</li>
                    </ul>
                </div>
                <div class="col-md-9 col-12">
                    <h3>Tip for remembering</h3>
                    <div v-html="meaningMnemonic">

                    </div>
                </div>
            </div>


        </b-tab>

        <!-- Not used for radicals -->
        <b-tab v-if="item.word_type_id != 1" id="tab-readings" title="Readings">
            <p v-for="reading in item.readings" :key="reading.id">
                {{reading.reading}}
            </p>
        </b-tab>

        <b-tab id="tab-examples" title="Examples">
            <p>Examples</p>
        </b-tab>
    </b-tabs>
</template>

<script>
    import marked from "marked"

    export default {
        name: "VocabItemContent",
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        data: function(){
            return {
                activeTab: 0,
            }
        },
        computed: {
            meaningMnemonic(){
                if(this.item.meaning_mnemonic) {
                    return marked(this.item.meaning_mnemonic);
                }else{
                    return "";
                }
            }
        }
    }
</script>

<style scoped>

</style>
