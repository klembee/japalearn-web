<template>
    <b-tabs class="tabs" v-model="activeTab" align="center">
        <!-- Tab only used for kanjis -->
        <b-tab v-if="item.word_type_id === 2" id="tab-radicals" title="Radicals">
            <!-- Radicals in the kanji -->

        </b-tab>

        <b-tab id="tab-meaning" title="Meaning">
            <p v-for="meaning in item.meanings" :key="meaning.id">
                {{meaning.meaning}}
            </p>

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
    export default {
        name: "VocabItemContent.vue",
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
        }
    }
</script>

<style scoped>

</style>
